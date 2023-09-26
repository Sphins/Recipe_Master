<?php

switch ($_GET['users']):
    case 'logout':
        include_once '../app/controllers/userController.php';
        \App\Controllers\UserController\logoutAction();
        break;


endswitch;
