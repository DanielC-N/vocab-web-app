<?php
session_start();
setcookie(session_name(),session_id(),strtotime( '+30 days' ));

include_once 'modele.php'; 
// Fonction pour vérifier si l'utilisateur est connecté et a les droits d'accès nécessaires

// Rediriger l'utilisateur vers la page de connexion s'il n'est pas admin
if (!isAdmin()) {
    header('Location: login.php');
    exit;
}
