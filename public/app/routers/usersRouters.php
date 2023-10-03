<?php

switch ($_GET['users']):
    case 'show':
        include_once '../app/controllers/usersController.php';
        \App\Controllers\UsersController\showAction($connexion, $_GET['id']);
        break;

    case 'login':
        include_once '../app/controllers/usersController.php';
        App\Controllers\UsersController\loginAction($connexion);
        break;

    case 'submit':
        include_once '../app/controllers/usersController.php';
        App\Controllers\UsersController\submitAction($connexion, [
            'pseudo' => $_POST['pseudo'],
            'mdp' => $_POST['mdp']
        ]);
        break;
    case 'index':
        include_once '../app/controllers/usersController.php';
        \App\Controllers\UsersController\indexAction($connexion);
        break;
endswitch;
