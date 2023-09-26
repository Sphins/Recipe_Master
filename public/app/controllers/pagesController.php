<?php

namespace App\Controllers\PagesController;

use App\Models\DishesModel;
use App\Models\UsersModel;

function homeAction(\PDO $connexion)
{
    // Définition de la limite pour le nombre de recettes à récupérer
    $limitation = 3;

    // Inclusion des modèles nécessaires pour les opérations suivantes
    include_once '../app/models/dishesModel.php';
    include_once '../app/models/usersModel.php';

    // Récupération d'une recette aléatoire pour l'affichage dynamique à chaque chargement de la page
    $rand = DishesModel\randOneDishes($connexion);

    // Récupération des 3 recettes les mieux notées pour l'affichage dans les cartes sur la page d'accueil
    $dishes  = DishesModel\findPopularDishes($connexion, $limitation);

    // Récupération des informations de l'utilisateur ayant les recettes les mieux notées sur le site
    $topUser = UsersModel\getTopUser($connexion);

    // Récupération des 3 meilleures recettes de cet utilisateur pour les afficher sur la page d'accueil
    $topUserDishes = DishesModel\getTopDishesByUserId($connexion, $topUser['user_id']);

    // Configuration du titre et du contenu pour la vue
    // Le titre de la page est défini et le contenu est généré en incluant la vue correspondante
    global $content, $title;
    $title = "Acceuil";
    ob_start(); // Démarre la temporisation de sortie
    include '../app/views/pages/home.php'; // Inclusion de la vue
    $content = ob_get_clean(); // Récupère le contenu actuel du tampon de sortie puis l'efface
}
