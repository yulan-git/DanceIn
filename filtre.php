<?php

// On autorise Ajax
header('Access-Control-Allow_Origin: *');

//On vérifie qu'on utilise la méthode GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // on se connecte à la base de données
    require_once('connect.php');

    $sql = 'SELECT nom_event, latGPS, lonGPS, ( 6371 * acos( cos( radians(:lat) ) * cos( radians( latGPS ) ) * cos( radians( lonGPS ) - radians(:lon) ) + sin( radians(:lat) ) * sin( radians( latGPS ) ) ) ) AS distance, date_debut, date_fin FROM event E INNER JOIN event_categorie EC ON E.id_event = EC.id_event AND id_categorie = :categorie INNER JOIN event_niveau EN ON E.id_event = EN.id_event AND id_niveau = :niveau INNER JOIN event_style ES ON E.id_event = ES.id_event AND id_style = :style INNER JOIN periode P ON E.id_event = P.id_event AND date_debut>=:dateDebut AND date_fin<=:dateFin HAVING distance < 30 ORDER BY distance';

    $query = $bdd->prepare($sql);

    $query->bindValue(':lat', $_GET['latGPS'], PDO::PARAM_STR);
    $query->bindValue(':lon', $_GET['lonGPS'], PDO::PARAM_STR);
    $query->bindValue(':distance', $_GET['distance'], PDO::PARAM_INT);
    $query->bindValue(':categorie', $_GET['categorie'], PDO::PARAM_INT);
    $query->bindValue(':niveau', $_GET['niveau'], PDO::PARAM_INT);
    $query->bindValue(':style', $_GET['style'], PDO::PARAM_INT);
    $query->bindValue(':dateDebut', $_GET['dateTimeDebut'], PDO::PARAM_STR);
    $query->bindValue(':dateFin', $_GET['dateTimeFin'], PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll();

    http_response_code(200);

    echo json_encode($result);

    require_once('close.php');
} else {
    http_response_code(405);
    echo 'Méthode non autorisée';
}
