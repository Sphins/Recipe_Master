<?php
// ROUTER PRINCIPAL
// Ce fichier sert de routeur principal pour orienter les requêtes vers les contrôleurs correspondants.

// DISHES.INDEX: Liste des dishes
// PATTERN: ?dishes=index
// CTRL: dishesController
// ACTION: index
// Si la variable GET 'dishes' est définie, le routeur inclus le fichier dishesRouters.php.
if (isset($_GET['dishes'])) :
    include_once '../app/routers/dishesRouters.php';

// USERS.INDEX: Liste des users
// PATTERN: ?users=index
// CTRL: usersController
// ACTION: index
// Si la variable GET 'users' est définie, le routeur inclus le fichier usersRouters.php.
elseif (isset($_GET['users'])) :
    include_once '../app/routers/usersRouters.php';

// CATEGORIES.INDEX: Liste des recettes d'une catégorie
// PATTERN: /?categories=show&id=x
// CTRL: categoriesController
// ACTION: show
// Si la variable GET 'categories' est définie, le routeur inclus le fichier categoriesRouters.php.
elseif (isset($_GET['categories'])) :
    include_once '../app/routers/categoriesRouters.php';

// INGREDIENTS.INDEX: Liste des recettes d'un ingrédient
// PATTERN: /?ingredients=show&id=x
// CTRL: ingredientsController
// ACTION: show
// Si la variable GET 'ingredients' est définie, le routeur inclus le fichier ingredientsRouters.php.
elseif (isset($_GET['ingredients'])) :
    include_once '../app/routers/ingredientsRouters.php';

// Route AJAX: pour gérer les requêtes AJAX.
// Si la variable GET 'ajax' est définie, le routeur inclus le fichier ajaxRouters.php.
elseif (isset($_GET['ajax'])) :
    include_once '../app/routers/ajaxRouters.php';

// Dans le cas où aucune des variables GET définies n'est présente,
// Le contrôleur de pages est inclus et l'action homeAction est appelée avec la connexion en paramètre.
else :
    include_once '../app/controllers/pagesController.php';
    \App\Controllers\PagesController\homeAction($connexion);
endif;
