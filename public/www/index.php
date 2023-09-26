<?php

// 1. Chargement du fichier d'initialisation
require_once '../core/init.php';

// 2. Chargement du router
require_once '../app/routers/indexRouters.php';

// 3. Chargement du template

if (!isset($_GET['ajax'])) {
    // La requête n'est pas une requête AJAX
    require_once '../app/views/template/index.php';
}
