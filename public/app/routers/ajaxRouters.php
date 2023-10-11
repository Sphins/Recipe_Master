<?php
// Ce fichier sert de routeur pour les requêtes AJAX.

// En fonction de la valeur de la variable 'ajax' dans $_GET, différentes actions sont effectuées.
switch ($_GET['ajax']):

        // Dans le cas où 'ajax' est égal à 'loadMoreDishes':
    case 'loadMoreDishes':
        // Inclure le contrôleur dishesController.php
        include_once '../app/controllers/dishesController.php';
        // Appeler la fonction loadMoreAction du namespace APP\Controllers\DishesController
        // avec la connexion et la valeur de la variable 'offSet' dans $_GET en tant que paramètres.
        APP\Controllers\DishesController\loadMoreAction($connexion, $_GET['offSet']);
        break;

        // Dans le cas où 'ajax' est égal à 'loadMoreUsers':
    case 'loadMoreUsers':
        // Inclure le contrôleur usersController.php
        include_once '../app/controllers/usersController.php';
        // Appeler la fonction loadMoreAction du namespace APP\Controllers\UsersController
        // avec la connexion et la valeur de la variable 'offSet' dans $_GET en tant que paramètres.
        APP\Controllers\UsersController\loadMoreAction($connexion, $_GET['offSet']);
        break;

// Fin de la structure switch
endswitch;
