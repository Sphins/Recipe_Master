<?php

//initialisation des zones dynamiques
$title = '';
$content = '';

//dossiers

define('PUBLIC_FOLDER', 'public');
define('ADMIN_FOLDER', 'admin');
define('DISPATCHER_NAME', 'index.php');
define('IMG_FOLDER', 'C:\Users\Sphins\Dropbox\htdocs\scripts_serveurs\Recipe_master\public\www\img\\');
define('IMG_DEFAULT', 'https://spoonacular.com/recipeImages/632151-556x370.jpg');


//nom back office
define('PROJECT_NAME', strtoupper('Recipe Master'));

// Paramètres de connexion à la DB
define('DB_HOST', '127.0.0.1:3306');
define('DB_NAME', 'recipe_master');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
