<?php

namespace App\Controllers\UsersController;

use App\Models\UsersModel;
use App\Models\DishesModel;

function indexAction(\PDO $connexion)
{
    include_once '../app/models/usersModel.php';
    $users = UsersModel\findAll($connexion);

    global $content, $title, $users_title, $zoneScripts;
    $title = "Chefs";
    $users_title = "Users";
    $zoneScripts = '<script src="./js/index.js"></script>';
    ob_start();
    include '../app/views/users/_showUsers.php';
    include '../app/views/js/_loadMoreUsers.php';
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
    include_once '../app/models/dishesModel.php';

    $user = UsersModel\findOneByUserId($connexion, $id);
    $dishes = DishesModel\findAllByUserId($connexion, $id);



    global $content, $title;
    $title = "Users-" . $user['user_name'];
    ob_start();
    include '../app/views/users/show.php';
    $content = ob_get_clean();
}

function loginAction(\PDO $connexion)
{
    global $title, $content;
    $title = "login";
    ob_start();
    include '../app/views/users/usersLogin.php';
    $content = ob_get_clean();
}

function submitAction(\PDO $connexion, array $data = null)
{
    include '../app/models/usersModel.php';
    $user = UsersModel\findOneByPseudo($connexion, $data);

    if ($user && password_verify($data['mdp'], $user['password'])) :
        // Vérifiez si le hachage nécessite une mise à jour
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $newHashedPassword = password_hash($data['mdp'], PASSWORD_DEFAULT);
            // Mettez à jour le mot de passe haché dans la base de données
            UsersModel\updateUserPassword($connexion, $user['id'], $newHashedPassword);
        }

        $_SESSION['user'] = $user;

        header('location: ' . ADMIN_ROOT);
    else :
        header('location: ' . PUBLIC_ROOT . 'users/login');
    endif;
}
