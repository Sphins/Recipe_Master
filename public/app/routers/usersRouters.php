<?php

switch ($_GET['users']):
    case 'show':
        include_once '../app/controllers/usersController.php';
        \App\Controllers\UsersController\showAction($connexion, $_GET['id']);
        break;

    default:
        include_once '../app/controllers/usersController.php';
        \App\Controllers\UsersController\indexAction($connexion);
        break;
endswitch;
