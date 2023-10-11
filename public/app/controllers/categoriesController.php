<?php

// Déclaration du namespace pour ce contrôleur
namespace App\Controllers\CategoriesController;

// Importation des classes nécessaires du namespace App\Models
use App\Models\CategoriesModel;
use App\Models\DishesModel;

// Fonction showAction qui est responsable de montrer une catégorie spécifique
// et les plats associés à cette catégorie
function showAction(\PDO $connexion, int $id)
{
    // Inclusion du fichier du modèle de catégories
    include_once '../app/models/categoriesModel.php';

    // Appel de la fonction findOneById du modèle CategoriesModel pour récupérer une catégorie spécifique par ID
    $category = CategoriesModel\findOneById($connexion, $id);

    // Inclusion du fichier du modèle de plats
    include_once '../app/models/dishesModel.php';

    // Appel de la fonction findAllDishesByCategoryId du modèle DishesModel pour récupérer tous les plats associés à l'ID de la catégorie
    $dishes = DishesModel\findAllDishesByCategoryId($connexion, $id);

    // Utilisation des variables globales $content, $title, et $dishes_title
    // pour stocker respectivement le contenu, le titre de la page, et le titre des plats
    global $content, $title, $dishes_title;

    // Assignation du nom de la catégorie aux variables globales $dishes_title et $title
    $dishes_title = $category['name'];
    $title = $category['name'];

    // Démarrage de la temporisation de sortie
    // Le contenu généré après cette fonction sera stocké dans le buffer interne
    ob_start();

    // Inclusion de la vue _showDishes.php pour afficher les plats
    include '../app/views/dishes/_showDishes.php';

    // Assignation du contenu du buffer interne à la variable globale $content
    // et nettoyage du buffer
    $content = ob_get_clean();
}
