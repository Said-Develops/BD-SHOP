<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";


// Ici on prepare une requete qui va nous permettre de stocker a partir de la table category le nom de la categorie 
// et son id dans un nouveau tableau qu'on appelle souvent $recordset
$stmt = $db->prepare("SELECT category_name,category_id FROM table_category");
$stmt->execute();
$recordset = $stmt->fetchAll();


// Ici pareil sauf qu'on va chercher le type id et le type name a partir de la table type et qu'on stock
// dans un autre tableau appelé recordset2
$stmt = $db->prepare("SELECT type_id,type_name FROM table_type");
$stmt->execute();
$recordset2 = $stmt->fetchAll();


// ici on initialise des variables avec des valeurs nul pour que par la suite ca ne genere pas d'erreur dans le formulaire
// si les variables ne sont pas écrasé par le if en dessous car elles ne sont pas écrasé dans le cas ou on ajoute 
// un nouveau produit car il n'y a donc pas de valeur de base vu que c'est un nouveau produit
$product_id = 0;
$product_slug = "";
$product_name = "";
$product_serie = "";
$product_volume = 0;
$product_description = "";
$product_price = 0;
$product_stock = 0;
$product_publisher = "";
$product_author = "";
$product_cartoonist = "";
$product_image = "imgNotFound.webp";
$product_resume = "";
$product_date = "";
$product_status = 0;
$product_type_id = 0;


// Comme dit plus haut ici on va écraser les variables initialiser plus haut pour que les champs soient pré-remplis
// dans le formulaire car on a des valeur de base car c'est une modification de produit.
// On arrive a savoir que ca va être une modification et pas un nouvel ajout car on recoit un id via la methode GET et donc
// on rentre bien dans la boucle 
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $stmt = $db->prepare("SELECT * FROM table_product WHERE product_id=:id");
    // ici on va remplacer l'id de la requete preparer par l'id obtenu avec la methode GET 
    $stmt->execute([":id" => $_GET['id']]);
    // On fait notre if qui va s'activer seulement si on arrive a stocker la sortie de la requete dans un tableau
    // appelé $row et si on y arrive pas on ne rentre pas dans la boucle, si par exemple l'id donné dans le lien
    // n'existe pas dans la BDD
    if ($row = $stmt->fetch()) {
        $product_id = $row["product_id"];
        $product_name = $row["product_name"];
        $product_serie = $row["product_serie"];
        $product_volume = $row["product_volume"];
        $product_description = $row["product_description"];
        $product_price = $row["product_price"];
        $product_stock = $row["product_stock"];
        $product_publisher = $row["product_publisher"];
        $product_author = $row["product_author"];
        $product_cartoonist = $row["product_cartoonist"];
        $product_image = $row["product_image"];
        $product_resume = $row["product_resume"];
        $product_date = $row["product_date"];
        $product_status = $row["product_status"];
        $product_type_id = $row["product_type_id"];
    }
}

// Ici on va faire la jointure entre la table product et sa table associative table_product_category
$stmt = $db->prepare("SELECT * 
                    FROM table_product
                    LEFT JOIN table_product_category
                    ON table_product.product_id = table_product_category.product_category_product_id
                    WHERE table_product.product_id=:product_id");
$stmt->bindValue(":product_id", $product_id);
$stmt->execute();
$recordset3 = $stmt->fetch();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Document</title>
</head>

<style>
    #btnEnregistrer {
        margin-top: 20px !important;
        margin-bottom: 20px ! important;
        background-color: lightgray;
    }



    .row {
        margin: 150px auto !important;
        padding: 120px 0px !important;
    }
</style>


<body class="bg-secondary-subtle">
    <div class="row">
        <div class="d-flex align-items-center justify-content-center vh-100">
            <!-- Le action du form va envoyer vers la page processAdd.php, cette page va recevoir le formulaire 
             par la method POST-->
            <form action="processAdd.php" method="POST" enctype="multipart/form-data" class="bg-light-subtle container w-50 border rounded m-6">
                <div class="col d-flex justify-content-center mt-5">
                    <h1>Ajout d'un produit</h1>
                </div>
                <label class="form-label" for="product_name">Nom du livre</label>
                <input value="<?= $product_name ?>" class="form-control" type="text" name="product_name">

                <label class="form-label" for="product_price">Prix du livre</label>
                <input value="<?= $product_price ?>" class="form-control" type="number" name="product_price">

                <label class="form-label" for="product_serie">Serie du produit</label>
                <input value="<?= $product_serie ?>" class="form-control" type="text" name="product_serie">

                <label class="form-label" for="product_volume">Volume du produit</label>
                <input value="<?= $product_volume ?>" class="form-control" type="number" name="product_volume">

                <label class="form-label" for="product_description">Description du produit</label>
                <input value="<?= $product_description ?>" class="form-control" type="text" name="product_description">

                <label class="form-label" for="product_stock">Stock du produit</label>
                <input value="<?= $product_stock ?>" class="form-control" type="number" name="product_stock">

                <label class="form-label" for="product_publisher">Publieur du produit</label>
                <input value="<?= $product_publisher ?>" class="form-control" type="text" name="product_publisher">

                <label class="form-label" for="product_author">Auteur du produit</label>
                <input value="<?= $product_author ?>" class="form-control" type="text" name="product_author">

                <label class="form-label" for="product_cartoonist">Cartooneur du produit</label>
                <input value="<?= $product_cartoonist ?>" class="form-control" type="text" name="product_cartoonist">

                <label class="form-label" for="product_image">Image du produit</label>
                <input value="<?= $product_image ?>" class="form-control" type="file" name="product_image">

                <label class="form-label" for="product_resume">Resume du produit</label>
                <input value="<?= $product_resume ?>" class="form-control" type="text" name="product_resume">

                <label class="form-label" for="product_date">Date de sortie du produit</label>
                <input value="<?= $product_date ?>" class="form-control" type="date" name="product_date">

                <label class="form-label" for="product_status">Status du produit</label>
                <input value="<?= $product_status ?>" class="form-control" type="number" name="product_status">




                <label class="form-label" for="category_id">Categorie du produit</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value=""></option>
                    <!-- ici la jointure faite plus haut va nous permettre de comparer les 4 category ID qui existent au category id du produit via notre variable $product_id -->
                    <?php foreach ($recordset as $categoryNameAndId) { ?>
                        <option value="<?=$categoryNameAndId["category_id"] ?>" <?=$recordset3 && $categoryNameAndId["category_id"] == $recordset3["product_category_category_id"] ? "selected" : ""; ?>><?=hsc($categoryNameAndId["category_name"])?></option>
                    <?php }
                    ?>
                </select>

                <label class=" form-label" for="type_id">Type du produit</label>
                <select class="form-control" name="type_id" id="type_id">
                    <option value=""></option>
                    <?php foreach ($recordset2 as $typeNameAndId) { ?>
                        <option value="<?= $typeNameAndId["type_id"] ?>" <?= $typeNameAndId["type_id"] == $product_type_id ? "selected" : ""; ?>><?= hsc($typeNameAndId["type_name"]) ?></option>
                    <?php }
                    ?>
                </select>
                <input type="hidden" name="token" value="<?= $_SESSION["token"];?>">
                <input type="hidden" name="product_id" value="<?= hsc($product_id); ?>">
                <input type="hidden" value="ok" name="sent">
                <input id="btnEnregistrer" class="form-control" type="submit" value="Enregistrer">
            </form>
        </div>
    </div>
</body>

</html>