<?php
// On essaie de se connecter à la base de données, si on y arrive pas renvoie un message d'erreur.
try{
// PDO est un objet de PHP qui permet de faire la connexion à la base de données
    $host = 'localhost'; // À modifier si besoin !
    $dbname = 'biblio';  // À modifier si besoin !
    $login = 'root';     // À modifier si besoin !
    $password = '';      // À modifier si besoin !
    $db = new PDO("mysql:host=".$host.";dbname=".$dbname.";charset=utf8",$login,$password);
}catch(Exception $e) {
    die($e->getMessage());
}
?>
