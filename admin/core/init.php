<?php

session_start();

// 1. Chargement des paramètres de connexion
require_once '../app/config/params.php';

// 2. Chargement des paramètres de constante
require_once '../core/constantes.php';

// 3. Chargement du fichier de connexion
require_once '../core/connexion.php';

// 4. Chargement des outils
require_once '../core/tools.php';

// 5. Chargement des paramètres de securité
require_once '../core/protection.php';
