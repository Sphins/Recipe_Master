<?php

namespace App\Controllers\TablesController;

use App\Models\TablesModel\Model;

function showTablesAction(\PDO $connexion)
{
    $model = new Model($connexion);
    $tables = $model->getTables();
    include '../app/views/tables/showTables.php';
    global $tables;
}

function showTable(\PDO $connexion, $selectedTable)
{
    $model = new Model($connexion);
    $data = $model->getTableData($selectedTable);
    $title = $selectedTable;
    include '../app/views/tables/show.php';

    global $content, $data, $title;
    $title = $selectedTable;
    ob_start();
    include '../app/views/template/partials/_main.php';
    $content = ob_get_clean();
};

function createForm(\PDO $connexion, $selectedTable)
{
    $model = new Model($connexion);
    $columns = $model->getTableStructure($selectedTable);
    $foreignKey = $model->getForeignKeys($selectedTable);
    $columsForeingnKey = $model->getDataFromForeingnKeys($foreignKey);

    // 1. Récupérer les métadonnées pour toutes les tables
    $allTables = $model->getAllTables();
    $nmRelations = [];

    foreach ($allTables as $table) {
        $metadata = $model->getMetadata($table);
        if ($metadata && isset($metadata['type']) && $metadata['type'] === 'nm') {
            if (($metadata['tables']['from']['name'] === $selectedTable && $metadata['tables']['from']['displayInForm']) ||
                ($metadata['tables']['to']['name'] === $selectedTable && $metadata['tables']['to']['displayInForm'])
            ) {
                $nmRelations[] = $metadata;
            }
        }
    }

    // 2. Récupérer les données nécessaires pour ces relations N:M
    $nmData = [];
    foreach ($nmRelations as $relation) {
        $relatedTable = ($relation['tables']['from']['name'] === $selectedTable) ? $relation['tables']['to']['name'] : $relation['tables']['from']['name'];
        $nmData[$relatedTable] = $model->getNMData($relation);
    }

    include '../app/views/form/createForm.php';

    global $content, $title, $selectedTable, $columns, $columsForeingnKey, $nmData;
    $title = $selectedTable;
    ob_start();
    include '../app/views/template/partials/_main.php';
    $content = ob_get_clean();
}

function addAction(\PDO $connexion, $selectedTable)
{
    $model = new Model($connexion);
    $insertedId = $model->insertData($selectedTable, $_POST);

    // Gérer les relations N:M
    $nmRelations = $model->getNMRelations($selectedTable);
    foreach ($nmRelations as $relation) {
        $relatedTable = ($relation['tables']['from']['name'] === $selectedTable) ? $relation['tables']['to']['name'] : $relation['tables']['from']['name'];
        if (isset($_POST[$relatedTable])) {
            foreach ($_POST[$relatedTable] as $relatedId) {
                $model->insertNMRelation($relation['junctionTable'], $insertedId, $relatedId);
            }
        }
    }

    header('location: ' . ADMIN_ROOT . "/table/show/" . $selectedTable);
}

function deleteAction(\PDO $connexion, $selectedTable, $elementId)
{
    $model = new Model($connexion);

    // 1. Supprimez les enregistrements dans les tables N:M associées
    $nmTables = $model->getNMTables($selectedTable);
    foreach ($nmTables as $nmTable) {
        $fromColumnName = $model->getMetadata($nmTable)['tables']['from']['column'];
        $model->deleteNMRecords($nmTable, $fromColumnName, $elementId);
    }

    // 2. Supprimez l'enregistrement de la table principale
    $model->deleteData($selectedTable, $elementId);

    // 3. Redirigez l'utilisateur vers la page d'affichage des données
    header('location: ' . ADMIN_ROOT . "/table/show/" . $selectedTable);
}
