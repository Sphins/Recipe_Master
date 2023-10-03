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

function createForm(\PDO $connexion, $selectedTable, $existingData = null)
{
    $model = new Model($connexion);
    $columns = $model->getTableStructure($selectedTable);
    $foreignKey = $model->getForeignKeys($selectedTable);
    $columsForeingnKey = $model->getDataFromForeingnKeys($foreignKey);

    // Récupérer les métadonnées pour toutes les tables
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

    // Récupérer les données nécessaires pour ces relations N:M
    $nmData = [];
    foreach ($nmRelations as $relation) {
        $relatedTable = ($relation['tables']['from']['name'] === $selectedTable) ? $relation['tables']['to']['name'] : $relation['tables']['from']['name'];
        $nmData[$relatedTable] = $model->getNMData($relation);
    }


    include '../app/views/form/createForm.php';

    global $content, $title, $selectedTable, $columns, $columsForeingnKey, $nmData, $existingData;
    $title = $selectedTable;
    ob_start();
    include '../app/views/template/partials/_main.php';
    $content = ob_get_clean();
}

function addAction(\PDO $connexion, $selectedTable)
{
    $model = new Model($connexion);

    // Password Hashing
    if (isset($_POST['password'])) {
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    if (isset($_POST['Password'])) {
        $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    }

    // Image Upload Handling
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $imagePath = handleImageUpload();
        if (!$imagePath) {
            $_POST['picture'] = IMG_DEFAULT;
        } else {
            $_POST['picture'] = $imagePath;
        }
    } else {
        $_POST['picture'] = IMG_DEFAULT;
    }

    // Data Insertion
    $insertedId = $model->insertData($selectedTable, $_POST);

    // N:M Relations Handling
    $nmRelations = $model->getNMRelations($selectedTable);
    foreach ($nmRelations as $relation) {
        $relatedTable = ($relation['tables']['from']['name'] === $selectedTable) ? $relation['tables']['to']['name'] : $relation['tables']['from']['name'];
        if (isset($_POST[$relatedTable])) {
            foreach ($_POST[$relatedTable] as $relatedId) {
                $additionalData = [];
                if (isset($relation['additionalColumns']) && isset($_POST['additional'])) {
                    foreach ($relation['additionalColumns'] as $additionalColumn) {
                        $additionalData[$additionalColumn['name']] = $_POST['additional'][$relatedId] ?? $additionalColumn['default'];
                    }
                }
                $model->insertNMRelation($relation['junctionTable'], $insertedId, $relatedId, $additionalData);
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

function editAction(\PDO $connexion, $selectedTable, $elementId)
{
    $model = new Model($connexion);

    // Étape 1: Récupérer les données existantes
    $existingData = $model->getDataById($selectedTable, $elementId);

    // Étape 2: Vérifier les relations N:M et récupérer les données liées
    $nmRelations = $model->getNMRelations($selectedTable);
    foreach ($nmRelations as $relation) {
        $relatedData = $model->getNMDataById($relation, $elementId);
        $existingData[$relation['tables']['to']['name']] = $relatedData;
    }

    // Étape 3: Générer et pré-remplir le formulaire
    createForm($connexion, $selectedTable, $existingData);
}


function updateAction(\PDO $connexion, $selectedTable, $elementId)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new Model($connexion);

        // Password Hashing
        if (isset($_POST['password'])) {
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        if (isset($_POST['Password'])) {
            $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        }

        // Image Upload Handling
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
            $imagePath = handleImageUpload();
            if (!$imagePath) {
                $_POST['picture'] = IMG_DEFAULT;
            } else {
                $_POST['picture'] = $imagePath;
            }
        } else {
            $_POST['picture'] = IMG_DEFAULT;
        }

        // Data Updating
        $model->updateData($selectedTable, $elementId, $_POST);

        $insertedId = $elementId;
        $nmRelations = $model->getNMRelations($selectedTable);
        foreach ($nmRelations as $relation) {
            $relatedTable = ($relation['tables']['from']['name'] === $selectedTable) ? $relation['tables']['to']['name'] : $relation['tables']['from']['name'];
            $fromColumn = $relation['tables']['from']['column'];
            $model->deleteNMRecords($relation['junctionTable'], $fromColumn, $elementId);

            if (isset($_POST[$relatedTable])) {
                foreach ($_POST[$relatedTable] as $relatedId) {
                    $additionalData = [];
                    if (isset($relation['additionalColumns']) && isset($_POST['additional'])) {
                        foreach ($relation['additionalColumns'] as $additionalColumn) {
                            $additionalData[$additionalColumn['name']] = $_POST['additional'][$relatedId] ?? $additionalColumn['default'];
                        }
                    }
                    $model->insertNMRelation($relation['junctionTable'], $insertedId, $relatedId, $additionalData);
                }
            }
        }

        header('location: ' . ADMIN_ROOT . "/table/show/" . $selectedTable);
    } else {
        header('location: ' . ADMIN_ROOT . "/table/edit/" . $selectedTable . '/' . $elementId);
    }
}

function handleImageUpload()
{
    // Nom par défaut de l'image
    $defaultImage = IMG_DEFAULT;

    // Vérifiez si le fichier image a été téléchargé
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {

        // Chemin de destination
        $target_file = IMG_FOLDER . basename($_FILES["picture"]["name"]);

        // Essayez de déplacer le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            return basename($_FILES["picture"]["name"]);
        } else {
            return $defaultImage;
        }
    } else {
        return $defaultImage;
    }
}
