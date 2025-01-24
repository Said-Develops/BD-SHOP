<?php
// Permet de travailler avec les variables de sessions $_SESSION
session_start();
// On vérifie que la clé 'is_logged' de la variable $_SESSION contient 'oui'
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] != 'oui') {
    // si la vérification n'est pas valide, on renvoie vers la page de login
    header("Location:/admin/login.php");
}

if (empty($_SESSION["token"])) {
    // idéalement je complete pour complexifier le chiffrage md5 car la c'est trop simple, par exemple en ajoutant un identifiant unique de l'utilisateur comme le mail
    $_SESSION['token'] = md5(date("Ymdhis"));
}

if(isset($_POST["token"]) && $_POST["token"]!=$_SESSION["token"]){
    redirect("/admin/login.php");
}

if(isset($_GET["token"])&& $_GET["token"]!=$_SESSION["token"]){
    redirect("/admin/login.php");
}
