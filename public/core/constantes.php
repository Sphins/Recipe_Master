<?php

// Définition de la constante PUBLIC_ROOT
// Cette constante représente l'URL de base pour accéder à la partie publique de votre application.
// - $_SERVER['HTTP_HOST'] contient le nom de l'hôte sous lequel la page actuelle est en cours d'exécution.
// - $_SERVER['PHP_SELF'] contient le nom du fichier de script en cours d'exécution, relative au document root.
// - str_replace(DISPATCHER_NAME, '', $_SERVER['PHP_SELF']) enlève le nom du dispatcher de l'URL, si présent.
define('PUBLIC_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/' . str_replace(DISPATCHER_NAME, '', $_SERVER['PHP_SELF']));

// Définition de la constante ADMIN_ROOT
// Cette constante représente l'URL de base pour accéder à la partie administrative de votre application.
// - str_replace(PUBLIC_FOLDER, ADMIN_FOLDER, PUBLIC_ROOT) remplace PUBLIC_FOLDER par ADMIN_FOLDER dans l'URL de PUBLIC_ROOT.
define('ADMIN_ROOT', str_replace(PUBLIC_FOLDER, ADMIN_FOLDER, PUBLIC_ROOT));
