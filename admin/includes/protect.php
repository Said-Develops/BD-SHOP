<?php
// Permet de travailler avec les variables de sessions $_SESSION
session_start();
// On vérifie que la clé 'is_logged' de la variable $_SESSION contient 'oui'
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] != 'oui'){
    // si la vérification n'est pas valide, on renvoie vers la page de login
    header("Location:login.php");
}