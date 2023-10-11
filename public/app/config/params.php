<?php

// Initialisation des variables pour les zones dynamiques du site.
// Ces variables peuvent être utilisées pour stocker et afficher le titre et le contenu des pages de manière dynamique.
$title = '';    // Variable pour stocker le titre de la page.
$content = '';  // Variable pour stocker le contenu de la page.

// Définition des constantes pour les noms de dossiers.
define('PUBLIC_FOLDER', 'public');     // Dossier contenant les fichiers publics (accessibles par les utilisateurs).
define('ADMIN_FOLDER', 'admin');       // Dossier contenant les fichiers de l'administration.
define('DISPATCHER_NAME', 'index.php'); // Nom du fichier principal (dispatcher) qui gère les requêtes.

// Définition de la constante pour le chemin du dossier d'images.
// Cette constante pourrait être utilisée pour créer des URLs absolues vers les images.
define('IMG_FOLDER', 'http://localhost/scripts_serveurs/Recipe_master/public/www/img/');

// Définition des constantes pour la connexion à la base de données.
// Ces constantes seront utilisées pour établir une connexion avec la base de données.
define('DB_HOST', '127.0.0.1:3306'); // Hôte et port de la base de données.
define('DB_NAME', 'recipe_master');  // Nom de la base de données.
define('DB_USERNAME', 'root');       // Nom d'utilisateur pour se connecter à la base de données.
define('DB_PASSWORD', 'root');       // Mot de passe pour se connecter à la base de données.
