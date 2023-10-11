<?php

// Déclaration du namespace pour ce contrôleur
namespace App\Controllers\IngredientsController;

// Importation des classes nécessaires du namespace App\Models
use App\Models\DishesModel;
use App\Models\IngredientsModel;

// Fonction showAction qui est responsable d'afficher un ingrédient spécifique
// et les plats associés à cet ingrédient
function showAction(\PDO $connexion, int $id)
{
    // Inclusion du fichier du modèle des ingrédients
    include_once '../app/models/ingredientsModel.php';

    // Appel de la fonction findOneById du modèle IngredientsModel pour récupérer un ingrédient spécifique par ID
    $ingredient = IngredientsModel\findOneById($connexion, $id);

    // Inclusion du fichier du modèle des plats
    include_once '../app/models/dishesModel.php';

    // Appel de la fonction findAllDishesByIngredientId du modèle DishesModel pour récupérer tous les plats associés à l'ID de l'ingrédient
    $dishes = DishesModel\findAllDishesByIngredientId($connexion, $id);

    // Utilisation des variables globales $content, $title, et $dishes_title
    // pour stocker respectivement le contenu, le titre de la page, et le titre des plats
    global $content, $title, $dishes_title;

    // Assignation du nom de l'ingrédient aux variables globales $dishes_title et $title
    $dishes_title = $ingredient['name'];
    $title = $ingredient['name'];

    // Démarrage de la temporisation de sortie
    // Le contenu généré après cette fonction sera stocké dans le buffer interne
    ob_start();

    // Inclusion de la vue _showDishes.php pour afficher les plats
    // La vue utilise les variables $dishes, $title, et $dishes_title pour afficher les informations à l'utilisateur
    include '../app/views/dishes/_showDishes.php';

    // Assignation du contenu du buffer interne à la variable globale $content
    // et nettoyage du buffer
    $content = ob_get_clean();
}
