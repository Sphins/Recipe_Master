<?php
// Tentative de connexion à la base de données MySQL en utilisant PDO
try {
    // Création d'un nouvel objet PDO pour se connecter à la base de données
    // DB_HOST, DB_NAME, DB_USERNAME, et DB_PASSWORD doivent être préalablement définis
    $connexion = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Si la connexion est réussie, $connexion contiendra l'objet de connexion à la base de données
} catch (PDOException $e) { // Si une exception de type PDOException est levée (erreur de connexion)
    // Affichage du message d'erreur
    print "Erreur !: " . $e->getMessage() . "<br/>";
    // Arrêt du script
    die();
}
