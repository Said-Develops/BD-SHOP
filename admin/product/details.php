<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $stmt = $db->prepare("SELECT * FROM table_product WHERE product_id=:id");
    $stmt->execute([":id" => $_GET["id"]]);
    $recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location:index.php");
}

$pagePrecedente = $_GET["p"];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
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

        .product-image {
            max-width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .detail-item {
            border-bottom: 1px solid #dee2e6;
            padding: 12px 0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
        }

        @media (max-width: 768px) {
            .container {
                padding-top: 60px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <a href="index.php?p=<?= $pagePrecedente ?>" class="back-btn">&times;</a>

    <div class="container py-5">
        <?php foreach ($recordset as $dataItem) { ?>
            <div class="row g-4">
                <!-- Image du produit -->
                <div class="col-md-5">
                    <?php if (file_exists("../../upload/images/lg_" . $dataItem['product_image'])) { ?>
                        <img class="product-image rounded" src="../../upload/images/lg_<?= $dataItem["product_image"] ?>" alt="<?= $dataItem["product_name"] ?>">
                    <?php } else { ?>
                        <img class="product-image rounded" src="../../upload/images/<?= $dataItem["product_image"] ?>" alt="<?= $dataItem["product_name"] ?>">
                    <?php } ?>
                </div>

                <!-- Détails du produit -->
                <div class="col-md-7">
                    <div class="product-details">
                        <h2 class="mb-4"><?= $dataItem["product_name"] ?></h2>

                        <div class="detail-item">
                            <span class="detail-label">Prix:</span>
                            <span class="fs-4 text-primary ms-2"><?= $dataItem["product_price"] ?> €</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Série:</span>
                            <span class="ms-2"><?= $dataItem["product_serie"] ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Volume:</span>
                            <span class="ms-2"><?= $dataItem["product_volume"] ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Description:</span>
                            <p class="mt-2"><?= $dataItem["product_description"] ?></p>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Stock:</span>
                            <span class="ms-2 <?= $dataItem["product_stock"] > 0 ? 'text-success' : 'text-danger' ?>">
                                <?= $dataItem["product_stock"] ?> unités
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Éditeur:</span>
                            <span class="ms-2"><?= $dataItem["product_publisher"] ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Auteur:</span>
                            <span class="ms-2"><?= $dataItem["product_author"] ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Date de sortie:</span>
                            <span class="ms-2"><?= $dataItem["product_date"] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>