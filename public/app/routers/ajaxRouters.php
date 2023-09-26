<?php
switch ($_GET['ajax']):

    case 'loadMoreDishes':
        include_once '../app/controllers/dishesController.php';
        APP\Controllers\DishesController\loadMoreAction($connexion, $_GET['offSet']);
        break;

    case 'loadMoreUsers':
        include_once '../app/controllers/usersController.php';
        APP\Controllers\UsersController\loadMoreAction($connexion, $_GET['offSet']);
        break;

endswitch;
