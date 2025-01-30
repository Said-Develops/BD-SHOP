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

$pagePrecedente = $_GET["p"];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 45px;
            height: 45px;
            background-color: #ffffff;
            color: #333;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 28px;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
            line-height: 0;
            padding-bottom: 5px;
        }

        .back-btn:hover {
            background-color: #f8f9fa;
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            color: #2c3e50;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-label {
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .submit-btn {
            background-color: #4a90e2;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #357abd;
            transform: translateY(-1px);
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-select {
            height: 45px;
        }
    </style>
</head>

<body class="pb-5">
    <a href="index.php?p=<?= hsc($pagePrecedente) ?>" class="back-btn">&times;</a>

    <div class="container mt-5">
        <div class="form-container">
            <h1 class="form-title"><?= hsc($product_id) > 0 ? 'Modifier le produit' : 'Ajouter un nouveau produit' ?></h1>

            <form action="processAdd.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Informations principales -->
                    <div class="col-md-6 form-section">
                        <label class="form-label" for="product_name">Nom du livre</label>
                        <input value="<?= hsc($product_name) ?>" class="form-control" type="text" name="product_name" id="product_name">

                        <label class="form-label" for="product_serie">Série</label>
                        <input value="<?= hsc($product_serie) ?>" class="form-control" type="text" name="product_serie" id="product_serie">

                        <label class="form-label" for="product_volume">Volume</label>
                        <input value="<?= hsc($product_volume) ?>" class="form-control" type="number" name="product_volume" id="product_volume">

                        <label class="form-label" for="product_price">Prix</label>
                        <div class="input-group mb-3">
                            <input value="<?= hsc($product_price) ?>" class="form-control" type="number" step="0.01" name="product_price" id="product_price">
                        </div>
                    </div>

                    <!-- Informations complémentaires -->
                    <div class="col-md-6 form-section">
                        <label class="form-label" for="product_author">Auteur</label>
                        <input value="<?= hsc($product_author) ?>" class="form-control" type="text" name="product_author" id="product_author">

                        <label class="form-label" for="product_publisher">Éditeur</label>
                        <input value="<?= hsc($product_publisher) ?>" class="form-control" type="text" name="product_publisher" id="product_publisher">

                        <label class="form-label" for="product_stock">Stock</label>
                        <input value="<?= hsc($product_stock) ?>" class="form-control" type="number" name="product_stock" id="product_stock">

                        <label class="form-label" for="product_date">Date de sortie</label>
                        <input value="<?= hsc($product_date) ?>" class="form-control" type="date" name="product_date" id="product_date">
                    </div>
                </div>

                <!-- Description et résumé -->
                <div class="form-section">
                    <label class="form-label" for="product_description">Description</label>
                    <textarea class="form-control" name="product_description" id="product_description" rows="3"><?= hsc($product_description) ?></textarea>

                    <label class="form-label" for="product_resume">Résumé</label>
                    <textarea class="form-control" name="product_resume" id="product_resume" rows="3"><?= hsc($product_resume) ?></textarea>
                </div>

                <!-- Classifications -->
                <div class="row">
                    <div class="col-md-6 form-section">
                        <label class="form-label" for="category_id">Catégorie</label>
                        <select class="form-select" name="category_id" id="category_id">
                            <option value="">Sélectionner une catégorie</option>
                            <?php foreach ($recordset as $categoryNameAndId) { ?>
                                <option value="<?= hsc($categoryNameAndId["category_id"]) ?>" <?= $recordset3 && $categoryNameAndId["category_id"] == $recordset3["product_category_category_id"] ? "selected" : ""; ?>>
                                    <?= hsc($categoryNameAndId["category_name"]) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 form-section">
                        <label class="form-label" for="type_id">Type</label>
                        <select class="form-select" name="type_id" id="type_id">
                            <option value="">Sélectionner un type</option>
                            <?php foreach ($recordset2 as $typeNameAndId) { ?>
                                <option value="<?= hsc($typeNameAndId["type_id"]) ?>" <?= $typeNameAndId["type_id"] == $product_type_id ? "selected" : ""; ?>>
                                    <?= hsc($typeNameAndId["type_name"]) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Image et status -->
                <div class="row">
                    <div class="col-md-6 form-section">
                        <label class="form-label" for="product_image">Image</label>
                        <input class="form-control" type="file" name="product_image" id="product_image">
                    </div>

                    <div class="col-md-6 form-section">
                        <label class="form-label" for="product_status">Statut</label>
                        <select class="form-select" name="product_status" id="product_status">
                            <option value="1" <?= $product_status == 1 ? 'selected' : '' ?>>Actif</option>
                            <option value="0" <?= $product_status == 0 ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                </div>

                <!-- Champs cachés et bouton de soumission -->
                <input type="hidden" name="token" value="<?= $_SESSION["token"]; ?>">
                <input type="hidden" name="product_id" value="<?= hsc($product_id); ?>">
                <input type="hidden" name="sent" value="ok">

                <button type="submit" class="submit-btn w-100">
                    <?= $product_id > 0 ? 'Enregistrer les modifications' : 'Ajouter le produit' ?>
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>