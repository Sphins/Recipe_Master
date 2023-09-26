<?php

namespace App\Controllers\DishesController;

use App\Models\DishesModel;

function indexAction(\PDO $connexion)
{
    include_once '../app/models/dishesModel.php';
    $dishes = DishesModel\findAll($connexion);

    global $content, $title, $dishes_title, $zoneScripts;
    $title = "Dishes-index";
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
    $dishes = DishesModel\findAll($connexion, 6, $offset);

    include '../app/views/dishes/_dishesCard.php';
}
