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
 * Récupère les meilleures recettes d'un utilisateur spécifié par son ID.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $userId L'ID de l'utilisateur.
 * @return array Les meilleures recettes de l'utilisateur.
 */
function getTopDishesByUserId(\PDO $connexion, $userId)
{
    // Requête SQL pour récupérer les meilleures recettes d'un utilisateur spécifié
    $sql = "
        SELECT 
            dishes.name AS dish_name,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            dishes.description
        FROM dishes
        LEFT JOIN ratings ON dishes.id = ratings.dish_id
        WHERE dishes.user_id = :userId
        GROUP BY dishes.id
        ORDER BY average_rating DESC
        LIMIT 3
    ";

    // Préparation et exécution de la requête
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':userId', $userId, \PDO::PARAM_INT);
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}