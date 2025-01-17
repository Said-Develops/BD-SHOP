<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";



if (isset($_POST["sent"]) && $_POST["sent"] == "okidoki" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $stmt = $db->prepare("UPDATE table_product SET product_name=:product_name, product_price=:product_price WHERE product_id=:id");
    $stmt->bindValue(":product_name", $_POST["nom_produit"]);
    $stmt->bindValue(":product_price", $_POST["prix_produit"]);
    $stmt->bindValue(":id", $_GET['id']);
    $stmt->execute();
}
header("Location:index.php");
