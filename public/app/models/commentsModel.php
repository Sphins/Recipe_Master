<?php

namespace App\Models\CommentsModel;

/**
 * Récupère les commentaires associés à un plat spécifié par son identifiant.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $id L'identifiant du plat.
 * @return array Les commentaires associés au plat spécifié.
 */
function findCommentsByDishId(\PDO $connexion, int $id)
{
    // Requête SQL pour récupérer les commentaires associés à un plat spécifié.
    // Sélectionne le contenu du commentaire, le nom et la photo de l'utilisateur
    // qui a laissé le commentaire, ainsi que la date à laquelle le commentaire
    // a été créé. Les commentaires sont triés par date de création descendante.
    $sql = "
        SELECT 
            comments.content,
            users.name AS user_name,
            users.picture AS user_picture,
            comments.created_at
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.dish_id = :id
        ORDER BY comments.created_at DESC
    ";

    // Préparation et exécution de la requête, avec liaison du paramètre id.
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    // Retourne les résultats sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
