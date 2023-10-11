<?php

namespace App\Controllers\DishesController;

// Importation des classes nécessaires depuis le namespace App\Models
use App\Models\DishesModel;
use App\Models\IngredientsModel;
use App\Models\CommentsModel;

// Fonction indexAction qui est responsable d'afficher tous les plats.
function indexAction(\PDO $connexion)
{
    // Inclusion du modèle des plats.
    include_once '../app/models/dishesModel.php';
    // Appel de la fonction findAll pour récupérer tous les plats.
    $dishes = DishesModel\findAll($connexion);

    // Déclaration des variables globales utilisées dans la vue.
    global $content, $title, $dishes_title, $zoneScripts, $loadMoreInstruction;
    // Assignation des titres pour la page et la section des plats.
    $title = "Recettes";
    $dishes_title = "Dishes";
    $loadMoreInstruction = "loadMoreDishes";
    // Assignation du script à inclure.
    $zoneScripts = '<script src="./js/index.js"></script>';
    // Bufferisation du contenu.
    ob_start();
    // Inclusion des vues nécessaires.
    include '../app/views/dishes/_showDishes.php';
    include '../app/views/js/_loadMore.php';
    // Récupération et nettoyage du contenu bufferisé.
    $content = ob_get_clean();
}

// Fonction loadMoreAction pour charger plus de plats.
function loadMoreAction(\PDO $connexion, int $offset)
{
    // Inclusion du modèle des plats.
    include_once '../app/models/dishesModel.php';
    // Récupération des plats avec pagination.
    $dishes = DishesModel\findAll($connexion, 9, $offset);
    // Inclusion de la vue pour afficher les cartes de plats.
    include '../app/views/dishes/_dishesCard.php';
}

// Fonction showAction pour afficher un plat spécifique.
function showAction(\PDO $connexion, int $id)
{
    // Inclusion des modèles nécessaires.
    include_once '../app/models/dishesModel.php';
    include_once '../app/models/ingredientsModel.php';
    include_once '../app/models/commentsModel.php';

    // Récupération du plat, des ingrédients et des commentaires associés.
    $dish = DishesModel\findOneByDishId($connexion, $id);
    $ingredients = IngredientsModel\findIngredientsByDishId($connexion, $id);
    $comments = CommentsModel\findCommentsByDishId($connexion, $id);

    // Déclaration des variables globales.
    global $content, $title;
    // Assignation du titre de la page.
    $title = "Recette-" . $dish['dish_name'];
    // Bufferisation du contenu.
    ob_start();
    // Inclusion de la vue show.
    include '../app/views/dishes/show.php';
    // Récupération et nettoyage du contenu bufferisé.
    $content = ob_get_clean();
}

// Fonction searchAction pour rechercher des plats.
function searchAction(\PDO $connexion, string $search)
{
    // Inclusion du modèle des plats.
    include_once '../app/models/dishesModel.php';
    // Récupération des plats basés sur la recherche.
    $dishes = DishesModel\findAllBySearch($connexion, $search);

    // Déclaration des variables globales.
    global $content, $title;
    // Assignation du titre de la page.
    $title = "Resultat de votre recherche: " . $search;
    // Bufferisation du contenu.
    ob_start();
    // Inclusion de la vue _showDishes.
    include '../app/views/dishes/_showDishes.php';
    // Récupération et nettoyage du contenu bufferisé.
    $content = ob_get_clean();
}
