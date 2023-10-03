<?php


//Routes des users
if (isset($_GET['users'])) :
    include_once '../app/routers/users.php';

//Routes des show table
elseif (isset($_GET['table'])) :
    include_once '../app/routers/table.php';

else :
    include_once '../app/controllers/userController.php';
    \app\Controllers\UserController\dashboardAction($connexion);
endif;
