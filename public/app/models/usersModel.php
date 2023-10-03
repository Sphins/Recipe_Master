<?php

namespace App\Models\UsersModel;

/**
 * Récupère l'utilisateur ayant les recettes les mieux notées.
 *
 * Cette fonction retourne l'utilisateur qui a les meilleures notes moyennes pour ses recettes.
 * Elle prend en compte toutes les notes attribuées à toutes les recettes de l'utilisateur.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @return array Les informations de l'utilisateur ayant les recettes les mieux notées.
 */
function getTopUser(\PDO $connexion)
{
    // Requête SQL pour récupérer l'utilisateur ayant les recettes les mieux notées
    // ainsi que le nombre total de recettes qu'il a postées.
    $sql = "
        SELECT 
            users.id AS user_id,
            users.name AS user_name,
            users.picture AS user_picture,
            DATE(users.created_at) AS user_registration_date,
            COUNT(DISTINCT dishes.id) AS total_recipes
            FROM users
            LEFT JOIN dishes ON users.id = dishes.user_id
            LEFT JOIN ratings ON dishes.id = ratings.dish_id
            GROUP BY users.id
            ORDER BY COALESCE(AVG(ratings.value), 0) DESC
            LIMIT 1
    ";

    // Préparation et exécution de la requête
    $rs = $connexion->prepare($sql);
    $rs->execute();

    // Retourne le résultat sous forme de tableau associatif
    return $rs->fetch(\PDO::FETCH_ASSOC);
}

function findAll(\PDO $connexion, int $limit = 9, int $offset = 0)
{
    $sql = "
            SELECT 
            users.id AS user_id,
            users.name AS user_name,
            users.picture AS user_picture,
            users.biography AS user_biography,
            DATE(users.created_at) AS user_registration_date,
            COUNT(DISTINCT dishes.id) AS total_recipes,
            COALESCE(AVG(ratings.value), 0) AS average_rating,
            COUNT(DISTINCT comments.id) AS number_of_comments
            FROM users
            LEFT JOIN dishes ON users.id = dishes.user_id
            LEFT JOIN ratings ON dishes.id = ratings.dish_id
            LEFT JOIN comments ON dishes.id = comments.dish_id
            GROUP BY users.id
            ORDER BY users.created_at ASC
            LIMIT :limit
            OFFSET :offset
    ";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $rs->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

function findOneByUserId(\PDO $connexion, int $id)
{
    $sql = "
        SELECT 
            users.picture AS user_picture,
            users.name AS user_name,
            users.biography AS user_biography
        FROM users
        WHERE users.id = :id
    ";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetch(\PDO::FETCH_ASSOC);
}

function findOneByPseudo(\PDO $connexion, array $data = null)
{
    $sql = "SELECT * 
    FROM users 
    where name = :pseudo;
    ";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':pseudo', $data['pseudo'], \PDO::PARAM_STR);
    $rs->execute();
    return $rs->fetch(\PDO::FETCH_ASSOC);
}

function updateUserPassword(\PDO $connexion, $userId, $newHashedPassword)
{
    $query = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':password', $newHashedPassword);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
}
