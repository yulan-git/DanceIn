<?php

session_start();
$error = null;
$success = null;

$access = false;
if (isset($_SESSION['access']) && $_SESSION['access'] == 'ok') {
    $access = true;
} else {
    header("Location: connexion.php");
}


if (isset($_POST['submit'])) {

    // Nom de l'évènement
    $nomEvenement = isset($_POST['event']) ? $_POST['event'] : '';

    // Categorie
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';

    // Style 
    $styleSeclected = isset($_POST['style']) ? $_POST['style'] : '';

    // Niveau
    $niveau =  isset($_POST['niveau']) ? $_POST['niveau'] : '';

    // Lieu : adresse, latitute, longitude
    $adressePrincipale = isset($_POST['adressePrincipale']) ? $_POST['adressePrincipale'] : '';
    $cp = isset($_POST['cp']) ? $_POST['cp'] : '';
    $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
    $tabAdresse = [
        $adressePrincipale,
        $cp,
        $ville
    ];
    $adresseComplete = implode(', ', $tabAdresse);

    $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
    $latGPS = floatval($lat);
    $lon = isset($_POST['lon']) ? $_POST['lon'] : '';
    $lonGPS = floatval($lon);

    // Date
    $dateTimeDebut = isset($_POST['dateTimeDebut']) ? $_POST['dateTimeDebut'] : '';
    $dateTimeFin = isset($_POST['dateTimeFin']) ? $_POST['dateTimeFin'] : '';
    $dateDebut = str_replace('T', ' ', $dateTimeDebut) . ':00';
    $dateFin = str_replace('T', ' ', $dateTimeFin) . ':00';

    // Description
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    //Tarif
    $prix = isset($_POST['tarif']) ? $_POST['tarif'] : '';
    $tarif = floatval($prix);


    // Connexion à la BDD
    require_once('connect.php');

    // Insertion dans la table `event`
    $sql = "INSERT INTO event (Nom_event, adresse, latGPS, lonGPS, description, tarif) VALUES (?, ?, ?, ?, ?, ?)";
    $query = $bdd->prepare($sql);
    $query->execute([
        $nomEvenement,
        $adresseComplete,
        $latGPS,
        $lonGPS,
        $description,
        $tarif,
    ]);
    //Récupère 'id_event' de la table `event`
    $last_id_event = $bdd->lastInsertId();

    // Insertion dans la table `periode`
    $sql2 = 'INSERT INTO periode (id_event, date_debut, date_fin) VALUES (?, ?, ?)';
    $query2 = $bdd->prepare($sql2);
    $query2->execute([
        $last_id_event,
        $dateDebut,
        $dateFin
    ]);

    // Insertion dans la table `event_categorie`
    $sql3 = 'INSERT INTO event_categorie (id_event, id_categorie) VALUES (?, ?)';
    $query3 = $bdd->prepare($sql3);
    $query3->execute([
        $last_id_event,
        $categorie
    ]);

    //Insertion dans la table `style`
    $sql4 = 'INSERT INTO event_style (id_event, id_style) VALUES (?, ?)';
    $query4 = $bdd->prepare($sql4);
    foreach ($styleSeclected as $style) {
        $query4->execute([
            $last_id_event,
            $style
        ]);
    };

    // Insertion dans la table `event_niveau`
    $sql5 = 'INSERT INTO event_niveau (id_event, id_niveau) VALUES (?, ?)';
    $query5 = $bdd->prepare($sql5);
    $query5->execute([
        $last_id_event,
        $niveau
    ]);

    require_once('close.php');
}


$title = "Ajoute ton évènement";
require 'elements/header.php';
require_once 'functions.php';
require_once 'config.php';
?>

<body>
    <header class="topbar">
        <a href="indexSiteDance.php">
            <img src="css/img/logo2.jpg" class="logo">
        </a>
        <nav class="menu">
            <?= nav_menu('nav-link') ?>
        </nav>
    </header>
    <!-- end header-->

    <!-- content-->
    <div class="font">
        <div class="content">
            <div class="container">
                <div class="row">
                    <h2 class="col-10 event-title"><?= 'Bienvenue ' . $_COOKIE['pseudo'] . ' ! Ajoute ton évènement' ?></h2>
                    <a class="col-2 text-right" href="deconnexion.php" title="logout" class="btn btn-default">Déconnexion <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <div class="container">

                <div class="row">
                    <form class="form-horizontal" method="POST" action="#" id="form1">
                        <fieldset>
                            <!-- place-line1 input-->
                            <div class="form-block">
                                <div class="form-about">
                                    <label for="event">Le Nom de ton évenement</label>
                                    <input id="event" type="text" class="form-control" name="event">
                                </div>
                                <hr>
                                <div class="form-about">
                                    <label for="style" class="style">Quoi</label>
                                    <?= select('categorie', $categorie, CATEGORIE) ?>
                                </div>
                                <hr>
                                <div class="form-about">
                                    <label for="style">Style(s)</label>
                                    <?php foreach ($styles as $key => $style) : ?>
                                        <div class="checkbox">
                                            <?= checkbox('style', $key, $_POST); ?>
                                            <?= $key . ' : ' . $style ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <hr>
                                <div class="form-about">
                                    <label for="niveau" class="niveau">Niveau</label>
                                    <?= select('niveau', $niveau, NIVEAU) ?>
                                </div>
                                <hr>
                                <div class="form-about">
                                    <label for="Lieu">Lieu</label>
                                    <input id="adressePrincipale" type="text" class="form-control" placeholder="Rue, Avenue..." name="adressePrincipale">
                                    <input id="cp" type="text" class="form-control" placeholder="Code Postal" name="cp">
                                    <input id="ville" type="text" class="form-control" placeholder="Ville" name="ville">
                                    <input id="lat" type="text" class="form-control" value="" placeholder="Latitude" name="lat" readonly>
                                    <input id="lon" type="text" class="form-control" value="" placeholder="Longitude" name="lon" readonly>
                                </div>
                                <div id="dates">
                                    <hr>
                                    <div class="form-about">
                                        <label for="appt">Date de début</label>
                                        <input type="datetime-local" class="form-control" id="dteTimeDebut" name="dateTimeDebut">
                                    </div>
                                    <div class="form-about">
                                        <label for="appt">Date de fin</label>
                                        <input type="datetime-local" class="form-control" id="dteTimeFin" name="dateTimeFin">
                                    </div>
                                </div>
                                <div id='lien'>Ajouter une date</div>

                                <hr>
                                <div class="form-about">
                                    <label for="description">Description</label>
                                    <textarea id="description" type="text" class="form-control" rows="10" cols="40" name="description"></textarea>
                                </div>
                                <hr>
                                <div class="form-about">
                                    <label for="tarif">Tarif</label>
                                    <input id="tarif" type="text" class="form-control" name="tarif">
                                </div>
                                <div class="form-about">
                                    <div class="alert alert-warning">Avant de valider ! Vérifiez une dernière fois les informations saisies ! </div>
                                </div>
                                <div class="form-about row">
                                    <button class="col-3 btn btn-primary bouton" type="submit" name="submit">Valider</button>
                                    <a class="col-9 text-right" href="deconnexion.php" title="logout" class="btn btn-default">Déconnexion <i class="fas fa-sign-out-alt"></i></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require 'elements/footer.php';
