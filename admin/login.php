<?php
// On vérifie si le $_POST['sent'] existe et si le contenu est égal à 'ok'
if (isset($_POST['sent']) && $_POST['sent'] == 'ok') {
    // var_dump permet d'afficher les informations d'une variable. Très utile pour de débuggage.
    var_dump($_POST);
    // require_once signifie qu'il as besoin du fichier 'connect.php' pour pouvoir continuer. 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
    // Création de la requête SQL pour récupérer les informations utilisateurs qui correspond à l'email qui est inséré.
    $query = "SELECT * FROM table_admin WHERE admin_mail = :mail";
    $stmt = $db->prepare($query);
    // On change le marqueur par $_POST['admin_mail'] qui est récupérer du formulaire 
    // lors de l'appui sur le bouton 'Connexion'.
    $stmt->execute([":mail" => $_POST['admin_mail']]);
    // Si $row est vide, fetch renvoie false.   
    if ($row = $stmt->fetch()) {
        //On vérifie si le mot de passe est le même que celui dans la base de donnée.
        if (password_verify($_POST['admin_password'], $row['admin_password'])) {
            // Si le mot de passe est le même,
            // On démarre une sessions avec  session_start().
            session_start();
            // On initialise la $_SESSION qui à pour clé 'is_logged' et pour valeur 'oui'.
            $_SESSION['is_logged'] = 'oui';
            // et ensuite on redirige l'utilisateur vers la page index.php.
            header("Location:product/index.php");
        };
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Utilisation de bootstrap pour la partie front-end -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <title>Page de login</title>
</head>

<body class="bg-secondary-subtle">
    <div class="d-flex align-items-center justify-content-center vh-100 ">
        <form class="bg-light-subtle container w-25 border rounded m-6 connexion" action="login.php" method="POST">
            <div class="col d-flex justify-content-center mt-5 ">
                <h1>Biblio 📖</h1>
                <p></p>
            </div>
            <label class="form-label" for="admin_mail">Identifiant :</label>
            <input type="email" name="admin_mail" id="admin_mail" class="form-control" required />
            <label class="form-label" for="admin_password">Mot de passe :</label>
            <input type="password" name="admin_password" id="admin_password" class="form-control" required />
            <input type="hidden" name="sent" value="ok">
            <div class="row m-1">
                <input type="submit" value="Connexion" class="btn btn-primary mt-2 mb-4">
            </div>
        </form>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>