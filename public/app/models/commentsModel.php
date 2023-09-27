<?php

namespace App\Models\CommentsModel;

function findCommentsByDishId(\PDO $connexion, int $id)
{
    $sql = "
        SELECT 
            comments.content,
            users.name AS user_name,
            users.picture AS user_picture,  -- Corrected comment style
            comments.created_at
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.dish_id = :id
        ORDER BY comments.created_at DESC
    ";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
