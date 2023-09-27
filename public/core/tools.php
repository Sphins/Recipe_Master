<?php

namespace Core\Tools;

function slugify($str, $delimiter = '-')
{
    // Étape 1 : Conversion des caractères spéciaux
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

    // Étape 2 : Suppression des apostrophes
    $str = str_replace("'", "", $str);

    // Étape 3 : Remplacement des "&"
    $str = str_replace("&", "et", $str);

    // Étape 4 et 5 : Remplacement et suppression des caractères
    $patterns = [
        '/[^A-Za-z0-9-]+/',  // Caractères non alphanumériques
        '/[\s-]+/'           // Espaces et tirets multiples
    ];
    foreach ($patterns as $pattern) {
        $str = preg_replace($pattern, $delimiter, $str);
    }

    // Étape 6 : Suppression des espaces blancs et conversion en minuscules
    $str = strtolower(trim($str, $delimiter));

    // Retirer les tirets en début et fin de chaîne
    $str = trim($str, '-');

    return $str;
}

function truncate($string, $word_limit)
{
    $words = explode(" ", $string);
    $result = implode(" ", array_splice($words, 0, $word_limit));
    if (count($words) > $word_limit) {
        $result .= '...';
    }
    return $result;
}
