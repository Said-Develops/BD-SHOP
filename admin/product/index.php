<?php
// require_once signifie qu'il as besoin du fichier 'protect.php', fichier qui va faire la vérification de l'existance de la variable de session $_SESSION et son contenu. 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";
// Ici on prepare une requete pour avoir tous les champ de la table product
$stmt = $db->prepare("SELECT * FROM table_product");
// ici on execute la requete preparé
$stmt->execute();
// ici on récupere tout dans un tableau appele souvent "recordset" grace au fetchAll() qui va prendre toute ce vers quoi $stmt
// pointe et le stocker.
$recordset = $stmt->fetchAll();

// on stock le nombre de valeur affiché par page
$perPage = 50;
// ici on stock la variable page
$page = 1;

// On fait un if pour le cas ou un a un nombre "p" dans l'url pour le stocker dans page 
if (isset($_GET['p']) && $_GET['p'] > 0 && is_numeric($_GET['p'])) {
    $page = $_GET['p'];
}

// ici on va faire une requete pour avoir seulement les 50 premier resultat
$stmt = $db->prepare("SELECT * FROM table_product ORDER BY product_id DESC LIMIT :limit OFFSET :offset ");
// limit permet de limite le nombre de resultats reçu
$stmt->bindValue(":limit", $perPage, PDO::PARAM_INT);
// offset permet de "sauter" des resultats, c'est a dire il commence a partir de X, ici on fait un calcule avec $perPage
//  pour savoir on commence a combien, et cet ordre est execute par la requete avant le limit !! 
$stmt->bindValue(":offset", ($page - 1) * $perPage, PDO::PARAM_INT);
$stmt->execute();
$recordset = $stmt->fetchAll();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <title>Document</title>
    <style>
        .titleadd {
            display: flex;
            flex-direction: row-reverse;
            gap: 1em;
            margin: 20px;
        }

        /* Style de base de l'élément */
        .hover-scale-effect {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            position: relative;

            /* Ombre par défaut */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

            /* Transition fluide pour tous les effets */
            transition: all 0.3s ease-in-out;
        }

        /* Effet au hover */
        .hover-scale-effect:hover {
            /* Augmentation de l'échelle */
            transform: scale(1.05);

            /* Ombre plus prononcée et étendue */
            box-shadow:
                0 10px 20px rgba(0, 0, 0, 0.1),
                0 6px 6px rgba(0, 0, 0, 0.1);

            /* Légère élévation */
            transform: translateY(-5px) scale(1.05);
        }

        /* Optional: Ajout d'un effet de brillance */
        .hover-scale-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.1) 45%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.1) 55%,
                    transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .hover-scale-effect:hover::after {
            opacity: 1;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="titleadd"><a class="btn btn-primary btnAdd" href="addForm.php">Ajouter un item</a><a class="btn btn-primary" href="logout.php">Deconnexion</a></div>
        </div>
    </nav>

    <div class="d-flex flex-wrap gap-5 justify-content-center">
        <?php foreach ($recordset as $row) { ?>
            <div class="card  hovered hover-scale-effect" style="width: 18em;">
                <img src="../../upload/images/xs_<?= $row["product_image"] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= hsc($row["product_name"]); ?></h5>
                    <p class="card-text">Prix du produit : <?= hsc($row["product_price"]); ?>€</p>

                    <a class="btn btn-warning" href="addForm.php?id=<?= hsc($row['product_id']); ?>">Modifier</a>
                    <a class="btn btn-danger" href="delete.php?id=<?= hsc($row['product_id']); ?>">Supprimer</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php

    // on prepare une requete qui va compter le nombre de product ID total dans la table product
    $stmt = $db->prepare("SELECT COUNT(product_id) AS total FROM table_product");
    $stmt->execute();
    $row = $stmt->fetch();
    // ici on definit une variable total, elle est egal au contenu lié a la clef total dans le tableau $row
    $total = $row["total"];
    // on divise le total par le nombre de page qu'on a pour savoir combien il en faut et ceil arrondis a l'entier au dessus
    $nbPage = ceil($total / $perPage);

    ?>
    <?php slicePage($page, $nbPage); ?>

</body>

</html>