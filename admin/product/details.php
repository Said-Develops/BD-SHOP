<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $stmt = $db->prepare("SELECT * FROM table_product 
                            WHERE product_id=:id");
    $stmt->execute([":id" => $_GET["id"]]);
    $recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location:index.php");
}

$pagePrecedente = $_GET["p"]

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="">
    <a href="index.php?p=<?= $pagePrecedente ?>">Retour</a>

    <div class="d-flex justify-content-center align-items-center gap-5">
        <ul class="list-group list-group-flush border">
            <?php
            foreach ($recordset as $dataItem) { ?>

                <li class="list-group-item"> ID du produit : <?= $dataItem["product_id"] ?></li>
                <li class="list-group-item">Nom du produit : <?= $dataItem["product_name"] ?></li>
                <li class="list-group-item">Prix du produit : <?= $dataItem["product_price"] ?></li>
                <li class="list-group-item">Serie du produit : <?= $dataItem["product_serie"] ?></li>
                <li class="list-group-item">Volume du produit : <?= $dataItem["product_volume"] ?></li>
                <li class="list-group-item">Description du produit : <?= $dataItem["product_description"] ?></li>
                <li class="list-group-item">Stock du produit : <?= $dataItem["product_stock"] ?></li>
                <li class="list-group-item">Publieur du produit : <?= $dataItem["product_publisher"] ?></li>
                <li class="list-group-item">Auteur du produit : <?= $dataItem["product_author"] ?></li>
                <li class="list-group-item">Date de sortie du produit : <?= $dataItem["product_date"] ?></li>

            <?php  } ?>
        </ul>
        <img class="rounded border" src="../../upload/images/lg_<?= $dataItem["product_image"] ?>" alt="">
    </div>





</body>

</html>