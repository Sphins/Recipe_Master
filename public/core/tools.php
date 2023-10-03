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

function truncate($string, $char_limit)
{
    if (strlen($string) <= $char_limit) {
        return $string;
    }

    $last_space = strrpos(substr($string, 0, $char_limit), ' ');

    $truncated_string = substr($string, 0, ($last_space ? $last_space : $char_limit));

    if (strlen($string) > strlen($truncated_string)) {
        $truncated_string .= '...';
    }

    return $truncated_string;
}
