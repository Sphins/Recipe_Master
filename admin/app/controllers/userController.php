<?php

namespace App\Controllers\UserController;



function dashboardAction()
{
    global $title, $content;
    $title = "Dashboard";
    ob_start();
    include '../app/views/users/dashboard.php';
    $content = ob_get_clean();
}

function logoutAction()
{
    //je tue la variable de session user
    unset($_SESSION['user']);
    //je redirige vers le site public
    header('location: ' . PUBLIC_ROOT);
}
