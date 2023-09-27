<?php

switch ($_GET['ingredients']):
    case 'show':
        include_once '../app/controllers/ingredientsController.php';
        \App\Controllers\IngredientsController\showAction($connexion, $_GET['id']);
        break;

    default:
        include_once '../app/controllers/pagesController.php';
        \App\Controllers\PagesController\homeAction($connexion);
        break;
endswitch;
