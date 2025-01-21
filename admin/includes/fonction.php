<?php 

    function hsc($value) {
        if(is_null($value)){
            return "";
        }else {
            return htmlspecialchars($value);
        }
    }

    function slicePage($page,$nbPage){
        print '<ul class="pagination justify-content-center">';

        for($i=0;$i<5;$i++) {
            if($i==0){
                print '<li class="page-item"><a class="page-link" href="index.php?p=1">«</a></li>';
            }
            else if($i==1){
                print '<li class="page-item"><a class="page-link" href="index.php?p='  .(($page>1)? $page-1 : $page) .'">‹</a></li>';
            }
            else if($i==2){
                print '<li class="page-item"><a class="page-link" href="index.php?p=' .$page. '"> ' . $page . '</a></li>';
            }
            else if($i==3){
                print '<li class="page-item"><a class="page-link" href="index.php?p='.(($page < $nbPage) ? $page + 1 : $nbPage).'">›</a></li>';
            }
            else if($i==4){
                print '<li class="page-item"><a class="page-link" href="index.php?p='.$nbPage. '">»</a></li>';
            }
        }
        print '</ul>';
    }
    
?>