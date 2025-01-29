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
    <title>Document</title>
</head>

<body>
    <form action="inscription.php" method="post">

        <label for="admin_mail">Identifiant</label>
        <input type="text" id="admin_mail" name="admin_mail">

        <label for="admin_password">Mot de passe</label>
        <input type="password" name="admin_password" id="admin_password">

        <label for="admin_password2">Retapez votre mot de passe</label>
        <input type="password" name="admin_password2" id="admin_password2">
        <input type="submit">
    </form>
    <?php
    if (isset($_POST["admin_password"]) && isset($_POST["admin_password2"])) {

        if ($_POST["admin_password"] != $_POST["admin_password2"]) {
    ?>
            <span>VOUS N'AVEZ PAS RETAPEZ LE MEME MOT DE PASSE</span>

        <?php    }
        ?>

    <?php } ?>
</body>

</html>