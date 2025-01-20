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
    <!-- pour naviguer a la page suivante on verifie qu'on est pas sur la derniere page sinon on rajoute +1 a l'id du lien -->
    <li class="page-item"><a class="page-link" href="index.php?p=<?= ($page < $nbPage) ? $page + 1 : $nbPage ?>">›</a></li>

    <!-- on va directement a la derniere page avec l'id de $nbpage  -->
    <li class="page-item"><a class="page-link" href="index.php?p=<?= $nbPage ?>">»</a></li>


</ul>