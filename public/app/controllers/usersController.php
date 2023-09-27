<?php

namespace App\Controllers\UsersController;

use App\Models\UsersModel;

function indexAction(\PDO $connexion)
{
    include_once '../app/models/usersModel.php';
    $users = UsersModel\findAll($connexion);

    global $content, $title, $users_title, $zoneScripts;
    $title = "Users-index";
    $users_title = "Users";
    $zoneScripts = '<script src="./js/index.js"></script>';
    ob_start();
    include '../app/views/users/_showUsers.php';  // Assuming you have a _showUsers.php file
    include '../app/views/js/_loadMoreUsers.php'; // Assuming you have a _loadMoreUsers.php file
    $content = ob_get_clean();
}

function loadMoreAction(\PDO $connexion, int $offset)
{
    include_once '../app/models/UsersModel.php';
    $users = UsersModel\findAll($connexion, 9, $offset);

    include '../app/views/users/_usersCard.php';
}

function showAction(\PDO $connexion, int $id)
{
    include_once '../app/models/usersModel.php';
    $user = UsersModel\findOneByUserId($connexion, $id);

    global $content, $title;
    $title = "Users-" . $user['name']; // Assurez-vous que 'name' est le champ correct dans votre base de données
    ob_start();
    include '../app/views/users/show.php';
    $content = ob_get_clean();
}
