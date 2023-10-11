<?php

namespace App\Models\CategoriesModel;

/**
 * Récupère tous les types de plats disponibles dans la base de données.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @return array La liste de tous les types de plats.
 */
function findAll(\PDO $connexion)
{
    // Requête SQL pour récupérer tous les types de plats dans la base de données.
    // Les résultats sont triés par nom de façon ascendante.
    $sql = "SELECT * 
            FROM types_of_dishes
            ORDER BY name ASC";

    // Exécution de la requête et récupération des résultats
    $rs = $connexion->query($sql);
    // Retourne les résultats sous forme de tableau associatif.
    return $rs->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Récupère un type de plat spécifique en fonction de son identifiant.
 *
 * @param \PDO $connexion La connexion à la base de données.
 * @param int $id L'identifiant du type de plat à récupérer.
 * @return array Les informations du type de plat spécifié.
 */
function findOneById(\PDO $connexion, $id)
{
    // Requête SQL pour récupérer un type de plat spécifique en fonction de son identifiant.
    $sql =  "SELECT *
            FROM types_of_dishes
            WHERE id = :id
    ";

    // Préparation de la requête
    $rs = $connexion->prepare($sql);
    // Liaison du paramètre id
    $rs->bindValue(':id', $id, \PDO::PARAM_INT);
    // Exécution de la requête
    $rs->execute();
    // Retourne le résultat sous forme de tableau associatif.
    return $rs->fetch(\PDO::FETCH_ASSOC);
}
