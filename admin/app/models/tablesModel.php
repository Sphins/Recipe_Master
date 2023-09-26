<?php

namespace App\Models\TablesModel;

class Model
{
    protected $connexion;

    public function __construct($connexion)
    {
        $this->connexion = $connexion;
    }

    public function getTables()
    {
        $query = "SHOW TABLES FROM " . DB_NAME;
        $result = $this->connexion->query($query);

        $tables = [];
        while ($row = $result->fetch(\PDO::FETCH_NUM)) {
            if (!$this->isManyToManyTable($row[0])) {
                $tables[] = $row[0];
            }
        }
        return $tables;
    }

    public function getAllTables()
    {
        $query = $this->connexion->prepare("SHOW TABLES");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }


    public function getTableData($tableName)
    {
        $query = $this->connexion->prepare("SELECT * FROM $tableName");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTableStructure($tableName)
    {
        $query = $this->connexion->prepare("DESCRIBE $tableName");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getForeignKeys($tableName)
    {
        $query = $this->connexion->prepare("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = :tableName 
            AND TABLE_SCHEMA = :databaseName
            AND REFERENCED_TABLE_NAME IS NOT NULL;
        ");
        $query->execute([':databaseName' => DB_NAME, ':tableName' => $tableName]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDataFromForeingnKeys($foreignKey)
    {
        $data = [];
        foreach ($foreignKey as $keyInfo) {
            $tableName = $keyInfo['REFERENCED_TABLE_NAME'];
            $data[$keyInfo['COLUMN_NAME']] = $this->getTableData($tableName);
        }
        return $data;
    }

    public function getMetadata($tableName)
    {
        $query = $this->connexion->prepare("SHOW TABLE STATUS WHERE Name = :tableName");
        $query->execute([':tableName' => $tableName]);
        $tableStatus = $query->fetch(\PDO::FETCH_ASSOC);
        $comment = $tableStatus['Comment'];
        if (!$comment) {
            return null; // Retourne null si pas de commentaire
        }
        return json_decode($comment, true);
    }

    public function getNMData($metadata)
    {
        $relatedTable = $metadata['tables']['to']['name'];

        $query = $this->connexion->prepare("SELECT * FROM $relatedTable");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTableColumns($tableName)
    {
        $stmt = $this->connexion->prepare("DESCRIBE $tableName");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    public function insertData($tableName, $postData)
    {
        // Étape 1: Récupérer les noms des colonnes de la table
        $columns = $this->getTableColumns($tableName);

        // Étape 2: Vérifier les données
        $data = array_filter($postData, function ($key) use ($columns) {
            return in_array($key, $columns) && $key !== 'id' && $key !== 'created_at';
        }, ARRAY_FILTER_USE_KEY);

        // Ajout de la date et de l'heure actuelles pour le champ created_at
        if (in_array('created_at', $columns)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        // Étape 3: Implode des noms de colonnes
        $columnNames = implode(", ", array_keys($data));

        // Étape 4: Créer les placeholders pour les valeurs
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        // Étape 5: Générer et exécuter la requête
        $query = "INSERT INTO $tableName ($columnNames) VALUES ($placeholders)";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute(array_values($data));

        // Retourner l'ID inséré pour une utilisation ultérieure si nécessaire
        return $this->connexion->lastInsertId();
    }

    public function getNMRelations($selectedTable)
    {
        $allTables = $this->getAllTables();
        $nmRelations = [];

        foreach ($allTables as $table) {
            $metadata = $this->getMetadata($table);
            if ($metadata && isset($metadata['type']) && $metadata['type'] === 'nm') {
                if ($metadata['tables']['from']['name'] === $selectedTable || $metadata['tables']['to']['name'] === $selectedTable) {
                    $nmRelations[] = $metadata;
                }
            }
        }

        return $nmRelations;
    }

    public function insertNMRelation($nmTable, $mainId, $relatedId)
    {
        $metadata = $this->getMetadata($nmTable);
        $fromColumn = $metadata['tables']['from']['column'];
        $toColumn = $metadata['tables']['to']['column'];

        $query = "INSERT INTO $nmTable ($fromColumn, $toColumn) VALUES (?, ?)";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([$mainId, $relatedId]);
    }

    public function deleteData($tableName, $id)
    {
        $query = "DELETE FROM $tableName WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteNMData($junctionTable, $columnName, $id)
    {
        $query = "DELETE FROM $junctionTable WHERE $columnName = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getNMTables($selectedTable)
    {
        $allTables = $this->getAllTables();
        $nmTables = [];

        foreach ($allTables as $table) {
            $metadata = $this->getMetadata($table);
            if ($metadata && isset($metadata['type']) && $metadata['type'] === 'nm') {
                if ($metadata['tables']['from']['name'] === $selectedTable || $metadata['tables']['to']['name'] === $selectedTable) {
                    $nmTables[] = $table;
                }
            }
        }

        return $nmTables;
    }

    public function deleteNMRecords($nmTable, $fromColumn, $elementId)
    {
        $query = "DELETE FROM $nmTable WHERE $fromColumn = :elementId";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':elementId', $elementId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    protected function isManyToManyTable($tableName)
    {
        $query = $this->connexion->prepare("
            SELECT TABLE_COMMENT 
            FROM INFORMATION_SCHEMA.TABLES 
            WHERE TABLE_SCHEMA = :databaseName AND TABLE_NAME = :tableName
        ");
        $query->execute([':databaseName' => DB_NAME, ':tableName' => $tableName]);
        $comment = $query->fetchColumn();

        $metadata = json_decode($comment, true);

        return isset($metadata['type']) && $metadata['type'] == 'nm';
    }
}
