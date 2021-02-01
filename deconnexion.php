<?php
session_start();

// Détruit toutes les variables de session
$_SESSION = [];

// Finalement, on détruit la session.
session_destroy();
setcookie('pseudo', '');

// Redirection vers la page d'identification
die(header('Location: connexion.php'));