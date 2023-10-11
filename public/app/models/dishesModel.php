<?php

namespace App\Models\DishesModel;

/**
 * Récupère une recette aléatoire dans la table dishes.
 *
 * @param \PDO $connexion Connexion active à la base de données.
 * @return array Un tableau associatif contenant les informations d'une recette aléatoire.
 */
function randOneDishes(\PDO $connexion)
{
    // La requête SQL récupère une recette aléatoire. Elle sélectionne diverses informations sur le plat
    // et effectue également une jointure avec la table des utilisateurs, des évaluations et des commentaires
    // pour récupérer des données associées.
    $sql = "
        SELECT 
            dishes.id AS dish_id,
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description,
            users.name AS user_name,
            COUNT(comments.id) AS number_of_comments
        FROM dishes
        LEFT JOIN users ON dishes.user_id = users.id
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        LEFT JOIN comments ON dishes.id = comments.dish_id
        GROUP BY dishes.id, users.name
        ORDER BY RAND()
        LIMIT 1;
    ";

    // Prépare et exécute la requête, puis retourne le résultat.
    $rs = $connexion->prepare($sql);
    $rs->execute();
    return $rs->fetch(\PDO::FETCH_ASSOC);
}


/**
 * Récupère les recettes les plus populaires selon leur note moyenne.
 *
 * @param \PDO $connexion Connexion active à la base de données.
 * @param int $limitation Nombre de recettes à récupérer.
 * @return array Un tableau associatif contenant les recettes les plus populaires.
 */
function findPopularDishes(\PDO $connexion, $limitation)
{
    // La requête SQL ci-dessous est destinée à récupérer les recettes ayant les meilleures notes moyennes.
    // Des jointures sont effectuées avec les tables users, ratings, et comments pour obtenir des données
    // complémentaires sur chaque recette. Les résultats sont triés par note moyenne descendante, puis limités
    // selon le paramètre $limitation.
    $sql = "
        SELECT 
            dishes.id AS dish_id,
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description,
            users.name AS user_name,
            COUNT(comments.id) AS number_of_comments
        FROM dishes
        LEFT JOIN users ON dishes.user_id = users.id
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        LEFT JOIN comments ON dishes.id = comments.dish_id
        GROUP BY dishes.id, users.name
        ORDER BY average_rating DESC
        LIMIT :limitation
    ";

    // Préparation et exécution de la requête avec la limitation spécifiée
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limitation', $limitation, \PDO::PARAM_INT);
    $rs->execute();

    // Récupération et retour des résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}



/**
 * Récupère les dernières recettes publiées par un utilisateur spécifié.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $userId L'ID de l'utilisateur concerné.
 * @return array Un tableau associatif des trois dernières recettes publiées par l'utilisateur.
 */
function getLastDishesByUserId(\PDO $connexion, $userId)
{
    // La requête SQL ci-dessous vise à obtenir les trois dernières recettes publiées par un utilisateur donné.
    // On utilise une jointure LEFT JOIN avec la table ratings pour calculer la note moyenne de chaque recette.
    // Les résultats sont groupés par ID de plat puis triés par date de création dans un ordre descendant,
    // ce qui permet d'obtenir les recettes les plus récentes en premier. On limite ensuite le résultat à trois.
    $sql = "
        SELECT 
            dishes.id AS dish_id,
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description
        FROM dishes
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        WHERE dishes.user_id = :userId
        GROUP BY dishes.id
        ORDER BY dishes.created_at DESC
        LIMIT 3
    ";

    // Préparation et exécution de la requête avec l'ID utilisateur spécifié
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':userId', $userId, \PDO::PARAM_INT);
    $rs->execute();

    // Récupération et retour des résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}



/**
 * Récupère toutes les recettes avec pagination.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $limit Le nombre maximum de recettes à retourner.
 * @param int $offset Le nombre de recettes à sauter dans le résultat total.
 * @return array Un tableau associatif des recettes.
 */
function findAll(\PDO $connexion, int $limit = 9, int $offset = 0)
{
    // La requête SQL ci-dessous vise à obtenir toutes les recettes avec des informations associées comme
    // la note moyenne, le nom de l'utilisateur qui a posté la recette et le nombre total de commentaires par recette.
    // Les résultats sont ensuite groupés par ID de plat et triés par date de création en ordre croissant.
    $sql = "
        SELECT 
            dishes.id AS dish_id,
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description,
            users.name AS user_name,
            COUNT(comments.id) AS number_of_comments
        FROM dishes
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        LEFT JOIN users ON dishes.user_id = users.id
        LEFT JOIN comments ON dishes.id = comments.dish_id
        GROUP BY dishes.id
        ORDER BY dishes.created_at ASC
        LIMIT :limit
        OFFSET :offset
    ";

    // Préparation de la requête avec la limite et l'offset spécifiés pour la pagination
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $rs->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $rs->execute();

    // Récupération et retour des résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère une recette en particulier par son ID.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $id L'identifiant de la recette.
 * @return array Les données de la recette spécifiée.
 */
function findOneByDishId(\PDO $connexion, int $id)
{
    // La requête ci-dessous sélectionne une recette par son ID. Elle récupère également
    // des informations associées, telles que la note moyenne, le temps de préparation,
    // et le nombre total de commentaires liés à cette recette.
    $sql = "
        SELECT
            dishes.picture AS picture, 
            dishes.id AS dish_id,
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.prep_time,
            dishes.description,
            users.name AS user_name,
            COUNT(comments.id) AS number_of_comments
        FROM dishes
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        LEFT JOIN users ON dishes.user_id = users.id
        LEFT JOIN comments ON dishes.id = comments.dish_id
        WHERE dishes.id = :id
        GROUP BY dishes.id
    ";

    // Préparation et exécution de la requête avec l'ID du plat spécifié.
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    // Retour des données sous forme de tableau associatif.
    return $rs->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les recettes publiées par un utilisateur spécifique.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $userId L'identifiant de l'utilisateur.
 * @return array Les recettes publiées par l'utilisateur spécifié.
 */
function findAllByUserId(\PDO $connexion, int $userId)
{
    // La requête ci-dessous sélectionne toutes les recettes publiées par un utilisateur,
    // identifié par son userId, avec des informations associées, telles que le nom du plat,
    // la description, l'ID du plat et la note moyenne.
    $sql = "
        SELECT 
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description AS dish_description,
            dishes.id AS dish_id
        FROM dishes
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        WHERE dishes.user_id = :userId
        GROUP BY dishes.id
        ORDER BY dishes.name ASC
    ";

    // Préparation et exécution de la requête avec le userId spécifié.
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':userId', $userId, \PDO::PARAM_INT);
    $rs->execute();

    // Retour des données sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les recettes associées à une catégorie spécifique.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $categoryId L'identifiant de la catégorie.
 * @return array Les recettes associées à la catégorie spécifiée.
 */
function findAllDishesByCategoryId(\PDO $connexion, int $categoryId)
{
    // Requête SQL pour récupérer tous les plats appartenant à une catégorie spécifiée par categoryId
    // avec des informations supplémentaires telles que le nom du plat, la note moyenne, la description, 
    // et l'ID du plat.
    $sql = "
    SELECT 
        dishes.name AS dish_name,
        COALESCE(AVG(ratings.value), 0) AS average_rating,
        dishes.description AS description,
        dishes.id AS dish_id,
        users.name AS user_name,
        COUNT(comments.id) AS number_of_comments
    FROM dishes
    LEFT JOIN ratings ON dishes.id = ratings.dish_id
    LEFT JOIN users ON dishes.user_id = users.id
    LEFT JOIN comments ON dishes.id = comments.dish_id
    WHERE dishes.type_id = :categoryId
    GROUP BY dishes.id
    ORDER BY dishes.name ASC
    ";

    // Préparation et exécution de la requête, avec liaison du paramètre categoryId.
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':categoryId', $categoryId, \PDO::PARAM_INT);
    $rs->execute();

    // Retour des résultats sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les plats associés à un ingrédient spécifique.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $ingredientId L'identifiant de l'ingrédient.
 * @return array Les plats associés à l'ingrédient spécifié.
 */
function findAllDishesByIngredientId(\PDO $connexion, int $ingredientId)
{
    // Requête SQL pour récupérer tous les plats associés à un ingrédient spécifié
    // avec des informations telles que le nom du plat, la note moyenne, la description,
    // l'ID du plat, et le nom de l'utilisateur.
    $sql = "
    SELECT 
        dishes.name AS dish_name,
        COALESCE(AVG(ratings.value), 0) AS average_rating,
        dishes.description AS description,
        dishes.id AS dish_id,
        users.name AS user_name,
        COUNT(comments.id) AS number_of_comments
    FROM dishes
    LEFT JOIN ratings ON dishes.id = ratings.dish_id
    LEFT JOIN users ON dishes.user_id = users.id
    LEFT JOIN comments ON dishes.id = comments.dish_id
    INNER JOIN dishes_has_ingredients ON dishes.id = dishes_has_ingredients.dish_id
    WHERE dishes_has_ingredients.ingredient_id = :ingredientId
    GROUP BY dishes.id
    ORDER BY dishes.name ASC
    ";

    // Préparation et exécution de la requête, avec liaison du paramètre ingredientId.
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':ingredientId', $ingredientId, \PDO::PARAM_INT);
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Recherche et récupère tous les plats qui correspondent à un terme de recherche.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param string $search Le terme de recherche.
 * @return array Les plats correspondant au terme de recherche.
 */
function findAllBySearch(\PDO $connexion, string $search)
{
    // Séparation des termes de recherche par espace.
    $words = explode(' ', trim($search));

    // Début de la requête SQL pour sélectionner les plats correspondant à la recherche.
    $sql = "
            SELECT DISTINCT 
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description AS description,
            dishes.id AS dish_id,
            users.name AS user_name,
            COUNT(comments.id) AS number_of_comments
            FROM dishes
            LEFT JOIN ratings ON dishes.id = ratings.dish_id
            LEFT JOIN users ON dishes.user_id = users.id
            LEFT JOIN comments ON dishes.id = comments.dish_id
            LEFT JOIN dishes_has_ingredients ON dishes.id = dishes_has_ingredients.dish_id
            LEFT JOIN ingredients ON dishes_has_ingredients.ingredient_id = ingredients.id
            WHERE 1=0";

    // Ajoute des conditions à la requête pour chaque terme de recherche.
    for ($i = 0; $i < count($words); $i++) :
        $sql .= "
            OR dishes.name          LIKE :word$i 
            OR dishes.description   LIKE :word$i 
            OR ingredients.name     LIKE :word$i";
    endfor;

    $sql .= "
            GROUP BY dishes.id 
            ORDER BY dishes.name ASC;";

    // Préparation et exécution de la requête, avec liaison des paramètres de recherche.
    $rs = $connexion->prepare($sql);
    for ($i = 0; $i < count($words); $i++) :
        $rs->bindValue(":word$i", '%' . $words[$i] . '%', \PDO::PARAM_STR);
    endfor;
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
