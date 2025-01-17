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
$stmt = $db->prepare("SELECT * FROM table_product LIMIT :limit OFFSET :offset");
$stmt->bindValue(":limit", $perPage, PDO::PARAM_INT);
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
        .display-5 {
            text-align: center;
        }

        .titleadd {
            position: relative;
        }

        .btnAdd {
            position: absolute;
            right: 52em;
            top: 1.5em;
            width: 10%;
            border: solid black 1px;
        }
    </style>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <caption>Liste des produits</caption>

            <tr>
                <div class="titleadd">
                    <th class="display-5" scope="col">Titre du livre</th>
                    <!-- ce "faux" bouton est enfaite un lien qui permet de rediriger vers addForm.php sans aucun id 
                     pour qu'il sache qu'on est la juste pour un ajout -->
                    <a class="btn btn-primary btnAdd" href="addForm.php">Ajouter</a>
                </div>
                <th class="display-5" scope="col">prix</th>
                <th class="display-5" scope="col">action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ici on a une boucle qui va permettre pour chaque "ligne" du tableau ou "tableau" dans le tableau $recordset
              de faire une itération  -->
            <?php foreach ($recordset as $row) { ?>
                <tr>

                    <!-- ici on utilise hsc qui est une fonction que on a crée et c'est une abréviation de htmlspecialchars qui permet
                     de sécuriser l'affichage en remplacant les caractéres spéciaux par leurs code html et donc eviter d'afficher du 
                     script si la BDD est compromise-->
                    <!-- On utilise $row["product_name"] pour dire que dans le tableau $row on va chercher ce qui est associé à
                     "product_name" car ce tableau est associatif et qu'il a donc dedans une valeur associé au "product_name". 
                     Enfin on affiche le contenu avec un ECHO -->

                    <td><?= hsc($row["product_name"]); ?></td>

                    <td><?= hsc($row["product_price"]); ?></td>
                    <td>

                        <!-- ici on a un "faux" bouton c'est enfaite un lien qui redirige vers notre fichier delete.php avec l'id 
                         du produit dans le lien pour que quand on arrive sur notre fichier delete.php il puisse recuperer 
                         l'id via la methode GET et savoir le quel il doit supprimer -->
                        <a class="btn btn-danger" href="delete.php?id=<?= hsc($row['product_id']); ?>">Supprimer</a>

                        <!-- ici le lien renvoi vers addForm.php qui est notre formulaire pour modifier et ajouter, et il envoi 
                         aussi l'id du produit via la methode GET c'est a dire dans le lien. Ce qui permet au formulaire de
                         savoir qu'on est la pour de la modification car on a un ID dans notre methode GET et permet aussi 
                         de savoir de quel produit on parle-->

                        <!--Et le fait de ne pas avoir d'id du tout permet au fichier addForm.php de savoir qu'on est la 
                          pour un ajout comme dit plus haut -->
                        <a class="btn btn-warning" href="addForm.php?id=<?= hsc($row['product_id']); ?>">Modifier</a>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php

    // on prepare une requete qui va compter le nombre de product ID total dans la table product
    $stmt = $db->prepare("SELECT COUNT(product_id) AS total FROM table_product");
    $stmt->execute();
    $row = $stmt->fetch();
    // ici on definit une variable total via le "AS total" de la requette
    $total = $row["total"];
    // ceil arrondis a l'entier au dessus, 
    $nbPage = ceil($total / $perPage); ?>


    <ul class="pagination justify-content-center">

        <li class="page-item"><a class="page-link" href="index.php?p=0">«</a></li>
        <li class="page-item"><a class="page-link" href="index.php?p=<?= ($page >= 2) ? $page - 1 : 1; ?>">‹</a></li>
        <!-- c'est une boucle for qui commence a 1 et continue de creer des liens vers les pages jusqu'a ce que il n'y en ai plus -->
        <?php for ($i = 1; $i <= $nbPage; $i++) { ?>

            <!-- ici c'est les "li" genere par le php au dessus elles vont creer un lien vers index.php?p= avec le bon nombre a la fin 
         et ca va aussi ECHO le nombre de la page vers la quel ca renvoi  -->
            <!-- on ajoute aussi la class active pour l'itération ou le $i est egal a $page donc pour savoir sur quel page on est -->
            <li class="page-item <?= ($i == $page) ? "active" : ""; ?>"><a class="page-link" href="index.php?p=<?= $i; ?>"><?= $i; ?></a></li>


        <?php } ?>
        <li class="page-item"><a class="page-link" href="index.php?p=<?=($page<$nbPage) ? $page+1:$nbPage?>">›</a></li>
        <li class="page-item"><a class="page-link" href="index.php?p=<?= $nbPage ?>">»</a></li>


    </ul>

</body>

</html>