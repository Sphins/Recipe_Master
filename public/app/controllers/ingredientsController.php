<?php

namespace App\Controllers\IngredientsController;

use App\Models\DishesModel;
use App\Models\IngredientsModel;

function showAction(\PDO $connexion, int $id)
{
    include_once '../app/models/ingredientsModel.php';

    $ingredient = IngredientsModel\findOneById($connexion, $id);

    include_once '../app/models/dishesModel.php';
    $dishes = DishesModel\findAllDishesByIngredientId($connexion, $id);

    global $content, $title, $dishes_title;
    $dishes_title = $ingredient['name'];
    $title = $ingredient['name'];
    ob_start();
    include '../app/views/dishes/_showDishes.php';
    $content = ob_get_clean();
}
