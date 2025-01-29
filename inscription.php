<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/fonction.php";




if (isset($_POST["admin_mail"]) && isset($_POST["admin_password"])) {

    if ($_POST["admin_password"] == $_POST["admin_password2"]) {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
        $stmt = $db->prepare("INSERT INTO table_admin (admin_mail,admin_password)
                            VALUES (:admin_mail, :admin_password)");
        $hashed_password = password_hash($_POST["admin_password"], PASSWORD_DEFAULT);
        $stmt->bindValue(":admin_mail", $_POST["admin_mail"]);
        $stmt->bindValue(":admin_password", $hashed_password);
        $stmt->execute();
        session_start();
        // On initialise la $_SESSION qui à pour clé 'is_logged' et pour valeur 'oui'.
        $_SESSION['is_logged'] = 'oui';
        // et ensuite on redirige l'utilisateur vers la page index.php.
        header("Location:admin/product/index.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="bg-secondary-subtle">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="inscription-container">
            <form action="inscription.php" method="post" class="inscription-form connexion">
                <div class="text-center mb-4">
                    <h1 class="inscription-title">Inscription</h1>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin_mail">Identifiant :</label>
                    <input type="text" id="admin_mail" name="admin_mail"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin_password">Mot de passe :</label>
                    <input type="password" class="form-control"
                        name="admin_password" id="admin_password" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin_password2">Confirmez le mot de passe :</label>
                    <input type="password" class="form-control"
                        name="admin_password2" id="admin_password2" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                    <a href="login.php" class="btn btn-outline-secondary">Retour à la connexion</a>
                </div>

                <?php if (
                    isset($_POST["admin_password"]) && isset($_POST["admin_password2"])
                    && $_POST["admin_password"] != $_POST["admin_password2"]
                ) : ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Les mots de passe ne correspondent pas. Veuillez réessayer.
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>

</html>