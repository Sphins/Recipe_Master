<?php

namespace App\Models\IngredientsModel;

function findIngredientsByDishId(\PDO $connexion, int $id)
{
    $sql = "
        SELECT 
            ingredients.unit,
            ingredients.name,
            dishes_has_ingredients.quantity
        FROM dishes_has_ingredients
        JOIN ingredients ON dishes_has_ingredients.ingredient_id = ingredients.id
        WHERE dishes_has_ingredients.dish_id = :id
    ";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
