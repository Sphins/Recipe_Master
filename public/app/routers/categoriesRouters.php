<?php
// Ce fichier sert de routeur pour les requêtes liées aux catégories.

// Utilisation de la structure switch pour diriger la requête vers l'action appropriée en fonction de la valeur de $_GET['categories'].
switch ($_GET['categories']):
        // Dans le cas où 'categories' est égal à 'show':
    case 'show':
        // Inclure le fichier categoriesController.php.
        include_once '../app/controllers/categoriesController.php';
        // Appeler la fonction showAction du namespace \App\Controllers\CategoriesController
        // en passant la connexion et la valeur de la variable 'id' dans $_GET en tant que paramètres.
        \App\Controllers\CategoriesController\showAction($connexion, $_GET['id']);
        break; // Fin de ce cas

// Fin de la structure switch
endswitch;
