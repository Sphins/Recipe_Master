<?php

switch ($_GET['dishes']):
        // case 'show':
        //     include_once '../app/controllers/dishesController.php';
        //     \App\Controllers\BooksController\showAction($connexion, $_GET['id']);
        //     break;

    default:
        include_once '../app/controllers/dishesController.php';
        \App\Controllers\DishesController\indexAction($connexion);
        break;
endswitch;
