<?php
// Fichier routeur pour les requêtes associées aux plats (dishes)

// On utilise la structure switch pour diriger la requête vers l'action appropriée.
// Le choix de l'action dépend de la valeur de $_GET['dishes'].
switch ($_GET['dishes']):
        // Cas où 'dishes' vaut 'show':
    case 'show':
        // Inclusion du contrôleur de plats.
        include_once '../app/controllers/dishesController.php';
        // Appel de la méthode showAction du contrôleur de plats.
        // On passe en paramètres la connexion à la base de données et l'identifiant du plat récupéré via $_GET.
        \App\Controllers\DishesController\showAction($connexion, $_GET['id']);
        break;

        // Cas où 'dishes' vaut 'search':
    case 'search':
        // Inclusion du contrôleur de plats.
        include_once '../app/controllers/dishesController.php';
        // Appel de la méthode searchAction du contrôleur de plats.
        // On passe en paramètres la connexion à la base de données et la chaîne de recherche récupérée via $_POST.
        \App\Controllers\DishesController\searchAction($connexion, $_POST['search']);
        break;

        // Cas par défaut: si 'dishes' n'a aucune des valeurs prévues ci-dessus.
    default:
        // Inclusion du contrôleur de plats.
        include_once '../app/controllers/dishesController.php';
        // Appel de la méthode indexAction du contrôleur de plats, en passant en paramètre la connexion à la base de données.
        \App\Controllers\DishesController\indexAction($connexion);
        break; // Fin de ce cas

// Fin de la structure switch.
endswitch;
