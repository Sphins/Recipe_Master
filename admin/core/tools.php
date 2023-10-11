<?php

namespace Core\Tools;

// Fonction pour slugifier une chaîne de caractères
// Cette fonction convertit une chaîne en un format "slug", utilisable dans les URL.
function slugify($str, $delimiter = '-')
{
    // Étape 1: Conversion des caractères spéciaux en ASCII équivalent
    // Utilisation de iconv pour translittérer les caractères non-ASCII
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

    // Étape 2: Suppression des apostrophes de la chaîne
    $str = str_replace("'", "", $str);

    // Étape 3: Remplacement des "&" par "et"
    $str = str_replace("&", "et", $str);

    // Étape 4 et 5: Application des motifs de remplacement et suppression des caractères non désirés
    $patterns = [
        '/[^A-Za-z0-9-]+/',  // Recherche des caractères non alphanumériques
        '/[\s-]+/'           // Recherche des espaces et tirets multiples et consécutifs
    ];
    foreach ($patterns as $pattern) {
        $str = preg_replace($pattern, $delimiter, $str); // Remplacement par le délimiteur
    }

    // Étape 6: Suppression des espaces blancs aux extrémités et conversion en minuscules
    $str = strtolower(trim($str, $delimiter));

    // Retirer les tirets en début et fin de chaîne si existants
    $str = trim($str, '-');

    // Retourne la chaîne slugifiée
    return $str;
}

// Fonction pour tronquer une chaîne de caractères à une limite de caractères spécifiée
function truncate($string, $char_limit)
{
    // Si la chaîne est plus courte ou égale à la limite, la retourner telle quelle
    if (strlen($string) <= $char_limit) {
        return $string;
    }

    // Trouver la position du dernier espace dans la sous-chaîne limitée par char_limit
    $last_space = strrpos(substr($string, 0, $char_limit), ' ');

    // Tronquer la chaîne à la position du dernier espace, ou à char_limit si aucun espace n'est trouvé
    $truncated_string = substr($string, 0, ($last_space ? $last_space : $char_limit));

    // Ajouter '...' à la fin de la chaîne tronquée si elle est plus courte que la chaîne originale
    if (strlen($string) > strlen($truncated_string)) {
        $truncated_string .= '...';
    }

    // Retourner la chaîne tronquée
    return $truncated_string;
}
