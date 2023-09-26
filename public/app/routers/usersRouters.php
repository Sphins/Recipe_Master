<?php

switch ($_GET['users']):
        // case 'show':
        //     include_once '../app/controllers/dishesController.php';
        //     \App\Controllers\BooksController\showAction($connexion, $_GET['id']);
        //     break;

    default:
        include_once '../app/controllers/usersController.php';
        \App\Controllers\UsersController\indexAction($connexion);
        break;
endswitch;
