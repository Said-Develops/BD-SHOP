<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/admin/includes/fonction.php";
if (isset($_POST["sent"]) && $_POST["sent"] == "ok") {
    foreach ($_POST as $key => $value) {
        setcookie($key, $value, time() + 86400, "/");
    }
}

redirect("index.php");
