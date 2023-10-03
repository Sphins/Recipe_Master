<?php

namespace App\Models\DishesModel;

/**
 * Récupère une recette aléatoire de la table dishes.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @return array La recette aléatoire.
 */
function randOneDishes(\PDO $connexion)
{
    // Requête SQL pour récupérer une recette aléatoire avec ses informations associées
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

    // Préparation et exécution de la requête
    $rs = $connexion->prepare($sql);
    $rs->execute();

    // Retourne le résultat sous forme de tableau associatif
    return $rs->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Récupère les recettes les plus populaires (en fonction de leur note moyenne).
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $limitation Le nombre de recettes à récupérer.
 * @return array Les recettes populaires.
 */
function findPopularDishes(\PDO $connexion, $limitation)
{
    // Requête SQL pour récupérer les recettes les mieux notées avec leurs informations associées
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

    // Préparation et exécution de la requête
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limitation', $limitation, \PDO::PARAM_INT);
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère les dernières recettes publiées par un utilisateur spécifié.
 *
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $userId L'ID de l'utilisateur.
 * @return array Les trois dernières recettes publiées par l'utilisateur.
 */
function getLastDishesByUserId(\PDO $connexion, $userId)
{
    // Requête SQL pour récupérer les trois dernières recettes publiées par un utilisateur spécifié
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

    // Préparation et exécution de la requête
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':userId', $userId, \PDO::PARAM_INT);
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

function findAll(\PDO $connexion, int $limit = 9, int $offset = 0)
{
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

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $rs->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

function findOneByDishId(\PDO $connexion, int $id)
{
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

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetch(\PDO::FETCH_ASSOC);
}

function findAllByUserId(\PDO $connexion, int $userId)
{
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

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':userId', $userId, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

function findAllDishesByCategoryId(\PDO $connexion, int $categoryId)
{
    $sql = "
    SELECT 
        dishes.name AS dish_name,
        COALESCE(AVG(ratings.value), 0) AS average_rating,
        dishes.description AS description,
        dishes.id AS dish_id,
        users.name AS user_name,
        COUNT(comments.id) AS number_of_comments  -- Ajouté cette ligne
    FROM dishes
    LEFT JOIN ratings ON dishes.id = ratings.dish_id
    LEFT JOIN users ON dishes.user_id = users.id
    LEFT JOIN comments ON dishes.id = comments.dish_id  -- Ajouté cette ligne
    WHERE dishes.type_id = :categoryId
    GROUP BY dishes.id
    ORDER BY dishes.name ASC
";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':categoryId', $categoryId, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

function findAllDishesByIngredientId(\PDO $connexion, int $ingredientId)
{
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

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':ingredientId', $ingredientId, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
