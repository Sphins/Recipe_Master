<?php
// ROUTER PRINCIPAL


// DISHES.INDEX: Liste des dishes
// PATTERN: ?dishes=index
// CTRL: dishesController
// ACTION: index

if (isset($_GET['dishes'])) :
    include_once '../app/routers/dishesRouters.php';

// USERS.INDEX: Liste des users
// PATTERN: ?users=index
// CTRL: usersController
// ACTION: index

elseif (isset($_GET['users'])) :
    include_once '../app/routers/usersRouters.php';

// CATEGORIES.INDEX /Liste des recettes d'une categories
// PATTERN: /?categories=show&id=x
//CTRL: categoriesController
//ACTION: show
elseif (isset($_GET['categories'])) :
    include_once '../app/routers/categoriesRouters.php';

// INGREDIENTS.INDEX /Liste des recettes d'un ingredient
// PATTERN: /?ingredients=show&id=x
//CTRL: ingredientsController
//ACTION: show
elseif (isset($_GET['ingredients'])) :
    include_once '../app/routers/ingredientsRouters.php';

//Route AJAX

elseif (isset($_GET['ajax'])) :
    include_once '../app/routers/ajaxRouters.php';

else :
    include_once '../app/controllers/pagesController.php';
    \App\Controllers\PagesController\homeAction($connexion);
endif;
