<?php

namespace App\Controllers\DishesController;

use App\Models\DishesModel;
use App\Models\IngredientsModel;
use App\Models\CommentsModel;

function indexAction(\PDO $connexion)
{
    include_once '../app/models/dishesModel.php';
    $dishes = DishesModel\findAll($connexion);

    global $content, $title, $dishes_title, $zoneScripts;
    $title = "Recettes";
    $dishes_title = "Dishes";
    $zoneScripts = '<script src="./js/index.js"></script>';
    ob_start();
    include '../app/views/dishes/_showDishes.php';
    include '../app/views/js/_loadMoreDishes.php';
    $content = ob_get_clean();
}

function loadMoreAction(\PDO $connexion, int $offset)
{
    include_once '../app/models/dishesModel.php';
    $dishes = DishesModel\findAll($connexion, 9, $offset);

    include '../app/views/dishes/_dishesCard.php';
}

function showAction(\PDO $connexion, int $id)
{
    include_once '../app/models/dishesModel.php';
    include_once '../app/models/ingredientsModel.php';
    include_once '../app/models/commentsModel.php';


    $dish = DishesModel\findOneByDishId($connexion, $id);
    $ingredients = IngredientsModel\findIngredientsByDishId($connexion, $id);
    $comments = CommentsModel\findCommentsByDishId($connexion, $id);


    global $content, $title;
    $title = "Recette-" . $dish['dish_name'];
    ob_start();
    include '../app/views/dishes/show.php';
    $content = ob_get_clean();
}
