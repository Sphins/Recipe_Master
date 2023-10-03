<?php

switch ($_GET['dishes']):
    case 'show':
        include_once '../app/controllers/dishesController.php';
        \App\Controllers\DishesController\showAction($connexion, $_GET['id']);
        break;

    case 'search':
        include_once '../app/controllers/dishesController.php';
        \App\Controllers\DishesController\searchAction($connexion, $_POST['search']);
        break;

    default:
        include_once '../app/controllers/dishesController.php';
        \App\Controllers\DishesController\indexAction($connexion);
        break;
endswitch;
