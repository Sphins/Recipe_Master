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


//Route AJAX

elseif (isset($_GET['ajax'])) :
    include_once '../app/routers/ajaxRouters.php';

else :
    include_once '../app/controllers/pagesController.php';
    \App\Controllers\PagesController\homeAction($connexion);
endif;
