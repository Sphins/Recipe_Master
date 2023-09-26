<?php
// ROUTER PRINCIPAL


// BOOKS.INDEX: Liste des dishes
// PATTERN: ?dishes=index
// CTRL: dishesController
// ACTION: index

if (isset($_GET['dishes'])) :
    include_once '../app/routers/dishesRouters.php';


//Route AJAX

elseif (isset($_GET['ajax'])) :
    include_once '../app/routers/ajaxRouters.php';

else :
    include_once '../app/controllers/pagesController.php';
    \App\Controllers\PagesController\homeAction($connexion);
endif;
