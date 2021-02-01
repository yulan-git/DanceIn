<?php
try {
    // Connexion à la bdd
    $bdd = new PDO('mysql:host=localhost;dbname=projetnfa021', 'root', 'root');
    $bdd->exec('SET NAMES "UTF8');
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}
