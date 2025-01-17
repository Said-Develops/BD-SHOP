<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";
$idprdt = $_GET['id'];

// CODE POUR AJOUTER UN PRODUIT QUI SERAI DIRECTEMENT RELIER A SA CATHEGORIE 
// $stmt = $db->prepare("SELECT category_name,product_type_id
// FROM table_category
// LEFT JOIN table_product ON table_category.category_id = table_product.product_type_id
// GROUP BY category_name");
// $stmt->execute();
// $recordset = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <form action="processModify.php?id=<?= hsc($idprdt); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom_produit">Nouveau nom</label>
            <input type="text" name="nom_produit">
        </div>
        <div class="form-group">

            <label for="prix_produit">Nouveau prix</label>
            <input type="number" name="prix_produit">
            <input type="hidden" value="okidoki" name="sent">
        </div>

        <button type="submit" class="btn btn-primary" value="Enregistrer">Submit</button>
    </form>

</body>


</html>