<?php
$title = 'Inscription';
$error = false;

if (!empty($_POST)) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (!$username || !$password || !$email) {
        $error = true;
    } else {

        require_once('connect.php');

        $sql = 'INSERT INTO organisateur (username, password, email) VALUES (?, ?, ?)';

        $query = $bdd->prepare($sql);

        $query->execute([
            $username,
            $password,
            $email
        ]);
        require_once('close.php');
        header('Location: connexion.php');
    }
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
                <h2>Inscris-toi !</h2>
            </div>

            <div class="container">
                <?php if (isset($_POST['submit']) && $error) : ?>
                    <div class="alert alert-danger">Echec de l'inscription, veuillez réessayer</div>
                <?php endif; ?>
                <div class="row">
                    <form class="form-horizontal" method="POST" action="#" id="form1">
                        <fieldset>
                            <!-- place-line1 input-->
                            <div class="form-block">
                                <div class="form-about">
                                    <label for="pseudo">Pseudo</label>
                                    <input id="pseudo" type="text" class="form-control" name="username">
                                </div>
                                <div class="form-about">
                                    <label for="password">Mot de Passe</label>
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>

                                <div class="form-about">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                </div>

                                <div class="form-about">
                                    <button class="btn btn-primary bouton" type="submit" name="submit">Valider</button>
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
