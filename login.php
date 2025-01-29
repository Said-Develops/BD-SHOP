<?php
// On vérifie si le $_POST['sent'] existe et si le contenu est égal à 'ok'
if (isset($_POST['sent']) && $_POST['sent'] == 'ok') {
    // var_dump permet d'afficher les informations d'une variable. Très utile pour de débuggage.

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
            header("Location:admin/product/index.php");
            exit();
        } else {
            $loginError = true; // Mot de passe incorrect
        }
    } else {
        $loginError = true; // Email non trouvé
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
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="login-container">
            <form class="connexion" action="login.php" method="POST">
                <div class="text-center">
                    <h1 class="login-title">BIBLIO 📖</h1>
                    <p class="login-subtitle">Un inventaire simple et complet de tous tes livres, accessible n'importe où.</p>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="admin_mail">Identifiant :</label>
                    <input type="text" name="admin_mail" id="admin_mail" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="admin_password">Mot de passe :</label>
                    <input type="password" name="admin_password" id="admin_password" class="form-control" required />
                </div>

                <input type="hidden" name="sent" value="ok">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Connexion</button>
                    <a href="inscription.php" class="btn btn-outline-secondary mb-5">S'inscrire</a>
                </div>
                <?php if (isset($_POST['sent']) && $loginError) { ?>
                    <div class="alert alert-danger" role="alert">
                        Identifiant ou mot de passe incorrect
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>