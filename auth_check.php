<?php
session_start();
setcookie(session_name(),session_id(),strtotime( '+30 days' ));

// Fonction pour vérifier si l'utilisateur est connecté
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
if (!isUserLoggedIn()) {
    header('Location: login.php');
    exit;
}
