<?php
// Fichier routeur pour les requêtes associées aux utilisateurs (users)

// Utilisation d'une structure switch pour diriger la requête vers l'action appropriée.
// Le choix de l'action dépend de la valeur de $_GET['users'].
switch ($_GET['users']):
        // Cas où 'users' vaut 'show':
    case 'show':
        // Inclusion du contrôleur des utilisateurs.
        include_once '../app/controllers/usersController.php';
        // Appel de la méthode showAction du contrôleur des utilisateurs.
        // On passe en paramètres la connexion à la base de données et l'identifiant de l'utilisateur récupéré via $_GET.
        \App\Controllers\UsersController\showAction($connexion, $_GET['id']);
        break;

        // Cas où 'users' vaut 'login':
    case 'login':
        // Inclusion du contrôleur des utilisateurs.
        include_once '../app/controllers/usersController.php';
        // Appel de la méthode loginAction du contrôleur des utilisateurs, en passant la connexion à la base de données en paramètre.
        App\Controllers\UsersController\loginAction($connexion);
        break;

        // Cas où 'users' vaut 'submit':
    case 'submit':
        // Inclusion du contrôleur des utilisateurs.
        include_once '../app/controllers/usersController.php';
        // Appel de la méthode submitAction du contrôleur des utilisateurs.
        // On passe en paramètres la connexion à la base de données et un tableau associatif contenant les valeurs de pseudo et mdp récupérées via $_POST.
        App\Controllers\UsersController\submitAction($connexion, [
            'pseudo' => $_POST['pseudo'],
            'mdp' => $_POST['mdp']
        ]);
        break;

        // Cas où 'users' vaut 'index':
    case 'index':
        // Inclusion du contrôleur des utilisateurs.
        include_once '../app/controllers/usersController.php';
        // Appel de la méthode indexAction du contrôleur des utilisateurs, en passant la connexion à la base de données en paramètre.
        \App\Controllers\UsersController\indexAction($connexion);
        break;

// Fin de la structure switch.
endswitch;
