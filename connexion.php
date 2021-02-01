<?php
session_start();
$title = 'Connexion';
$error = null;

if (isset($_POST['submit'])) {

    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    require_once('connect.php');

    $sql = ('SELECT * FROM organisateur WHERE username = :username');
    $query = $bdd->prepare($sql);
    $query->bindValue(':username', $_POST['username'], PDo::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($username) && !empty($password)) {
        if ($user == true) {
            if ($user['username'] === $username && password_verify($password, $user['password']) === true) {
                $_SESSION['access'] = "ok";
                setcookie("pseudo", $user['username']);
                header('Location: ajoutEvent.php');
                exit();
            } else {
                $error = "Identifiants incorrectes";
            }
        } else {
            $error = "Identifiants inexistants";
        }
    } else {
        $error = "Veuiller saisir vos identifiants";
    }

    require_once('close.php');
}

require 'elements/header.php';
require_once 'functions.php';
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

            <div class="form-block">
                <p>Tu es organisateur de soirées et tu souhaites partager un nouvel évènement, rien de plus simple!</p>
                <p>C'est la première fois, alors <strong><a href="inscription.php">inscris-toi</a></strong> à notre site !</p>
                <p>Sinon connecte-toi !</p>
            </div>


            <div class="container">
                <?php if ($error) : ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <div class="row">
                    <form class="form-horizontal" method="POST" action="#" id="form1">
                        <fieldset>
                            <!-- place-line1 input-->
                            <div class="form-block">
                                <div class="form-about">
                                    <label for="username">Pseudo</label>
                                    <input id="username" type="text" class="form-control" name="username">
                                    <div class="form-about"></div>
                                    <label for="password">Mot de Passe</label>
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                                <div class="form-about">
                                    <button class="btn btn-primary bouton" type="submit" name="submit">Connexion</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->
    <?php
    require 'elements/footer.php';
