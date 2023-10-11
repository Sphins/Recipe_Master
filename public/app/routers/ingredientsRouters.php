<?php
// Fichier routeur pour les requêtes associées aux ingrédients (ingredients)

// On utilise une structure switch pour diriger la requête vers l'action appropriée.
// Le choix de l'action dépend de la valeur de $_GET['ingredients'].
switch ($_GET['ingredients']):
        // Cas où 'ingredients' vaut 'show':
    case 'show':
        // Inclusion du contrôleur des ingrédients.
        include_once '../app/controllers/ingredientsController.php';
        // Appel de la méthode showAction du contrôleur des ingrédients.
        // On passe en paramètres la connexion à la base de données et l'identifiant de l'ingrédient récupéré via $_GET.
        \App\Controllers\IngredientsController\showAction($connexion, $_GET['id']);
        break;

        // Cas par défaut: si 'ingredients' n'a aucune des valeurs prévues ci-dessus.
    default:
        // Inclusion du contrôleur de pages.
        include_once '../app/controllers/pagesController.php';
        // Appel de la méthode homeAction du contrôleur de pages, en passant en paramètre la connexion à la base de données.
        \App\Controllers\PagesController\homeAction($connexion);
        break; // Fin de ce cas

// Fin de la structure switch.
endswitch;
