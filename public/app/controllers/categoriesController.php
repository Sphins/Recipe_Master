<?php

namespace App\Controllers\CategoriesController;

use App\Models\CategoriesModel;
use App\Models\DishesModel;

function showAction(\PDO $connexion, int $id)
{
    include_once '../app/models/categoriesModel.php';

    $category = CategoriesModel\findOneById($connexion, $id);

    include_once '../app/models/dishesModel.php';
    $dishes = DishesModel\findAllDishesByCategoryId($connexion, $id);

    global $content, $title, $dishes_title;
    $dishes_title = $category['name'];
    $title = $category['name'];
    ob_start();
    include '../app/views/dishes/_showDishes.php';
    $content = ob_get_clean();
}
