<?php
// require_once signifie qu'il as besoin du fichier 'protect.php', fichier qui va faire la vérification de l'existance de la variable de session $_SESSION et son contenu. 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";



// on stock le nombre de valeur affiché par page
$perPage = 50;
// ici on stock la variable page
$page = 1;

// On fait un if pour le cas ou un a un nombre "p" dans l'url pour le stocker dans page 
if (isset($_GET['p']) && $_GET['p'] > 0 && is_numeric($_GET['p'])) {
    $page = $_GET['p'];
}

// on divise la requete sql en plusieurs parties 
$sqlSELECT = "SELECT * FROM table_product";


$sqlWHERE = " WHERE 1=1";

if (!empty($_COOKIE["search"])) {
    $sqlWHERE .= " AND (product_name LIKE :product_name COLLATE utf8mb3_general_ci OR product_serie LIKE :product_serie COLLATE utf8mb3_general_ci OR product_author LIKE :product_author COLLATE utf8mb3_general_ci)";
}
if (!empty($_COOKIE["product_type_id"])) {
    $sqlWHERE .= " AND product_type_id=:product_type_id";
}

if (!empty($_COOKIE["priceMin"])) {
    $sqlWHERE .= " AND product_price >= :priceMin";
}

if (!empty($_COOKIE["priceMax"])) {
    $sqlWHERE .= " AND product_price <= :priceMax";
}

$sqlLIMIT = " LIMIT :limit OFFSET :offset";
// ici on va faire une requete pour avoir seulement les 50 premier resultat
$stmt = $db->prepare($sqlSELECT . $sqlWHERE . $sqlLIMIT);
if (!empty($_COOKIE["search"])) {
    $stmt->bindValue(":product_name", "%" . $_COOKIE["search"] . "%");
    $stmt->bindValue(":product_serie", "%" . $_COOKIE["search"] . "%");
    $stmt->bindValue(":product_author", "%" . $_COOKIE["search"] . "%");
}

if (!empty($_COOKIE['product_type_id'])) {
    $stmt->bindValue(":product_type_id", $_COOKIE['product_type_id']);
}

if (!empty($_COOKIE['priceMin'])) {
    $stmt->bindValue(":priceMin", $_COOKIE["priceMin"]);
}

if (!empty($_COOKIE['priceMax'])) {
    $stmt->bindvalue(":priceMax", $_COOKIE["priceMax"]);
}

// limit permet de limite le nombre de resultats reçu
$stmt->bindValue(":limit", $perPage, PDO::PARAM_INT);
// offset permet de "sauter" des resultats, c'est a dire il commence a partir de X, ici on fait un calcule avec $perPage
//  pour savoir on commence a combien, et cet ordre est execute par la requete avant le limit !! 
$stmt->bindValue(":offset", ($page - 1) * $perPage, PDO::PARAM_INT);

$stmt->execute();
$recordset = $stmt->fetchAll();

$stmt = $db->prepare("SELECT * FROM table_type ");
$stmt->execute();
$recordsetType = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>

<body class="bodyProductIndex">
    <nav id="nav" class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="logo">
                <a href="index.php"><img src="../../upload/logoipsum-293.svg" alt=""></a>
            </div>
            <div class="navItem">
                <a class="navtxt" href="addForm.php">Ajouter un article</a>
                <a class="navtxt" href="logout.php">Deconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <form action="updateSearchCookie.php" method="post">
           
                <div class="row g-2 align-items-center">
                    <!-- Barre de recherche -->
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Recherche" name="search" value="<?= !empty($_COOKIE["search"]) ? $_COOKIE["search"] : ""; ?>">
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div class="col">
                        <select class="form-select" name="product_type_id" id="product_type_id">
                            <option value="">Choisir</option>
                            <?php foreach ($recordsetType as $row_type) { ?>
                                <option value="<?= hsc($row_type["type_id"]) ?>" <?= (isset($_COOKIE['product_type_id'])) && $_COOKIE["product_type_id"] == $row_type['type_id'] ? "selected" : "" ?>><?= hsc($row_type["type_name"]) ?>
                                </option>
                            <?php }
                            ?>
                        </select>
                    </div>

                    <!-- Prix Min -->
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control" min="0" placeholder="Prix minimum" name="priceMin" value="<?= !empty($_COOKIE["priceMin"]) ? $_COOKIE["priceMin"] : ""; ?>">
                        </div>
                    </div>

                    <!-- Prix Max -->
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control" placeholder="Prix maximum" name="priceMax" value="<?= !empty($_COOKIE["priceMax"]) ? $_COOKIE["priceMax"] : ""; ?>">
                        </div>
                    </div>

                    <!-- Bouton -->
                    <div class="col-auto">
                        <input type="submit" class="btn btn-primary" value="recherche">
                        <input type="hidden" name="sent" value="ok">
                    </div>
                </div>
            
        </form>

    </div>




    <h1 class="h1ProductIndex">Votre Bibliothèque</h1>

    <div class="d-flex flex-wrap gap-5 justify-content-center">
        <?php foreach ($recordset as $row) { ?>
            <div class="card hover-scale-effect">
                <div class="image-hover-effect">
                    <a href="details.php?id=<?= hsc($row['product_id']); ?>&p=<?= $page ?>">

                        <?php if (file_exists("../../upload/images/xs_" . $row["product_image"])) { ?>
                            <img src="../../upload/images/xs_<?= $row["product_image"] ?>" class="card-img-top imgIndexProduct" alt="...">
                        <?php } else { ?>
                            <img src="../../upload/images/<?= $row["product_image"] ?>" class="card-img-top imgIndexProduct2" alt="...">


                        <?php } ?>

                        <div class="overlay">DETAILS</div>
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= hsc($row["product_name"]); ?></h5>
                    <p class="card-text">Prix du produit : <?= hsc($row["product_price"]); ?>€</p>
                    <a class="btn btn-warning" href="addForm.php?id=<?= hsc($row['product_id']); ?>">Modifier</a>
                    <a class="btn btn-danger" href="delete.php?id=<?= hsc($row['product_id']); ?>&token=<?= $_SESSION["token"]; ?>">Supprimer</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="d-flex justify-content-center m-5">
        <?php

        // on prepare une requete qui va compter le nombre de product ID total dans la table product
        $stmt = $db->prepare("SELECT COUNT(product_id) AS total FROM table_product" . $sqlWHERE);
        if (!empty($_COOKIE["search"])) {
            $stmt->bindValue(":product_name", "%" . $_COOKIE["search"] . "%");
            $stmt->bindValue(":product_serie", "%" . $_COOKIE["search"] . "%");
            $stmt->bindValue(":product_author", "%" . $_COOKIE["search"] . "%");
        }

        if (!empty($_COOKIE['priceMin'])) {
            $stmt->bindValue(":priceMin", $_COOKIE["priceMin"]);
        }

        if (!empty($_COOKIE['priceMax'])) {
            $stmt->bindvalue(":priceMax", $_COOKIE["priceMax"]);
        }


        if (!empty($_COOKIE['product_type_id'])) {
            $stmt->bindValue(":product_type_id", $_COOKIE['product_type_id']);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        // ici on definit une variable total, elle est egal au contenu lié a la clef total dans le tableau $row
        $total = $row["total"];
        // on divise le total par le nombre de page qu'on a pour savoir combien il en faut et ceil arrondis a l'entier au dessus
        $nbPage = ceil($total / $perPage);

        ?>
        <?php slicePage($page, $nbPage); ?>
    </div>
</body>

</html>