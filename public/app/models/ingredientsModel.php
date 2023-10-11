<?php

namespace App\Models\IngredientsModel;

/**
 * Récupère les ingrédients liés à un plat spécifique.
 *
 * Cette fonction retourne les ingrédients associés à un ID de plat spécifique,
 * y compris l'unité, le nom et la quantité de chaque ingrédient.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $id L'ID du plat.
 * @return array La liste des ingrédients associés au plat spécifié.
 */
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

/**
 * Récupère tous les ingrédients dans la base de données.
 *
 * Cette fonction retourne une liste de tous les ingrédients, triés par nom en ordre ascendant.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @return array La liste de tous les ingrédients.
 */
function findAll(\PDO $connexion)
{
    $sql = "SELECT * 
            FROM ingredients
            ORDER BY name ASC";
    $rs = $connexion->query($sql);
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère un ingrédient spécifique par ID.
 *
 * Cette fonction retourne les informations d'un ingrédient spécifique identifié par son ID.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $id L'ID de l'ingrédient.
 * @return array Les informations de l'ingrédient spécifié.
 */
function findOneById(\PDO $connexion, $id)
{
    $sql =  "SELECT *
            FROM ingredients
            WHERE id = :id
    ";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetch(\PDO::FETCH_ASSOC);
}
