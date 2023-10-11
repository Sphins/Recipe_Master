<?php

namespace App\Controllers\UsersController;

// Import des modèles nécessaires
use App\Models\UsersModel;
use App\Models\DishesModel;

// Action pour afficher tous les utilisateurs
function indexAction(\PDO $connexion)
{
    // Inclusion du modèle d'utilisateurs
    include_once '../app/models/usersModel.php';
    // Récupération de tous les utilisateurs
    $users = UsersModel\findAll($connexion);

    // Définition des variables globales utilisées dans les vues
    global $content, $title, $users_title, $zoneScripts, $loadMoreInstruction;
    $title = "Chefs";
    $users_title = "Users";
    $loadMoreInstruction = "loadMoreUsers";
    $zoneScripts = '<script src="./js/index.js"></script>';
    // Bufferisation du contenu généré
    ob_start();
    // Inclusion des vues correspondantes
    include '../app/views/users/_showUsers.php';
    include '../app/views/js/_loadMore.php';
    // Récupération et nettoyage du contenu bufferisé
    $content = ob_get_clean();
}

// Action pour charger plus d'utilisateurs
function loadMoreAction(\PDO $connexion, int $offset)
{
    include_once '../app/models/UsersModel.php';
    $users = UsersModel\findAll($connexion, 9, $offset);
    // Inclusion de la vue pour la carte utilisateur
    include '../app/views/users/_usersCard.php';
}

// Action pour afficher un utilisateur spécifique et ses plats
function showAction(\PDO $connexion, int $id)
{
    include_once '../app/models/usersModel.php';
    include_once '../app/models/dishesModel.php';

    $user = UsersModel\findOneByUserId($connexion, $id);
    $dishes = DishesModel\findAllByUserId($connexion, $id);

    // Définition des variables globales
    global $content, $title;
    $title = "Users-" . $user['user_name'];
    // Bufferisation du contenu
    ob_start();
    // Inclusion de la vue de l'utilisateur
    include '../app/views/users/show.php';
    // Récupération et nettoyage du contenu bufferisé
    $content = ob_get_clean();
}

// Action pour la page de connexion
function loginAction(\PDO $connexion)
{
    global $title, $content;
    $title = "login";
    ob_start();
    include '../app/views/users/usersLogin.php';
    $content = ob_get_clean();
}

// Action pour soumettre le formulaire de connexion
function submitAction(\PDO $connexion, array $data = null)
{
    include '../app/models/usersModel.php';
    $user = UsersModel\findOneByPseudo($connexion, $data);

    // Vérification des informations d'authentification
    if ($user && password_verify($data['mdp'], $user['password'])) :
        // Vérification si le hachage du mot de passe nécessite une mise à jour
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $newHashedPassword = password_hash($data['mdp'], PASSWORD_DEFAULT);
            // Mise à jour du mot de passe dans la base de données si nécessaire
            UsersModel\updateUserPassword($connexion, $user['id'], $newHashedPassword);
        }
        // Enregistrement de l'utilisateur dans la session
        $_SESSION['user'] = $user;
        // Redirection vers la page d'administration
        header('location: ' . ADMIN_ROOT);
    else :
        // Redirection vers la page de connexion en cas d'échec
        header('location: ' . PUBLIC_ROOT . 'users/login');
    endif;
}
