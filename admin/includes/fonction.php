<?php

function hsc($value)
{
    if (is_null($value)) {
        return "";
    } else {
        return htmlspecialchars($value);
    }
}

function slicePage($page, $nbPage)
{
    print '<ul class="pagination justify-content-center">';

    for ($i = 0; $i < 11; $i++) {
        if ($i == 0) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=1">«</a></li>';
        } else if ($i == 1) {
            print '<li class="page-item"><a class="page-link" href="index.php?p='  . (($page > 1) ? $page - 1 : $page) . '">‹</a></li>';
        } else if ($i == 2 && ($page > 3)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page - 3 . '"> ' . ($page - 3) . '</a></li>';
        } else if ($i == 3 && ($page > 2)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page - 2 . '"> ' . ($page - 2) . '</a></li>';
        } else if ($i == 4 && ($page > 1)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page - 1 . '"> ' . ($page - 1) . '</a></li>';
        } else if ($i == 5) {
            print '<li class="page-item"><a class="page-link active" href="index.php?p=' . $page . '"> ' . $page . '</a></li>';
        } else if ($i == 6 && ($page < $nbPage)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page + 1 . '"> ' . ($page + 1) . '</a></li>';
        } else if ($i == 7 && ($page < $nbPage-1)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page + 2 . '"> ' . ($page + 2) . '</a></li>';
        } else if ($i == 8 && ($page < $nbPage-2)) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $page + 3 . '"> ' . ($page + 3) . '</a></li>';
        } else if ($i == 9) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . (($page < $nbPage) ? $page + 1 : $nbPage) . '">›</a></li>';
        } else if ($i == 10) {
            print '<li class="page-item"><a class="page-link" href="index.php?p=' . $nbPage . '">»</a></li>';
        }
    }
    print '</ul>';
}


function securiseImage($fichier)
{
    // Définition des types MIME autorisés
    $typesPermis = [
        'image/jpeg',
        'image/png',
        'image/gif'
    ];

    // Taille maximale (5 Mo)
    $tailleMax = 5 * 1024 * 1024;

    try {
        // Vérification de l'upload
        if (!isset($fichier['error']) || is_array($fichier['error'])) {
            throw new RuntimeException('Paramètres invalides.');
        }

        // Vérification du code d'erreur
        switch ($fichier['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Le fichier dépasse la taille autorisée.');
            default:
                throw new RuntimeException('Erreur inconnue.');
        }

        // Vérification de la taille
        if ($fichier['size'] > $tailleMax) {
            throw new RuntimeException('Le fichier dépasse la taille maximale autorisée.');
        }

        // Vérification du type MIME
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($fichier['tmp_name']);

        if (!in_array($mimeType, $typesPermis)) {
            throw new RuntimeException('Format de fichier non autorisé.');
        }

        // Génération d'un nom unique
        $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
        $nomFichier = uniqid() . '.' . $extension;

        // Déplacement du fichier
        $destination = $_SERVER['DOCUMENT_ROOT'] . "/upload/images/". $nomFichier; // Assurez-vous que ce dossier existe
        if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
            throw new RuntimeException('Échec du déplacement du fichier.');
        }

        return [
            'success' => true,
            'message' => 'Image téléchargée avec succès',
            'nom_fichier' => $nomFichier
        ];
    } catch (RuntimeException $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function redirect($url) {
    header("Location:".$url);
    exit();
}
