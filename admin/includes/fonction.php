<?php 

    function hsc($value) {
        if(is_null($value)){
            return "";
        }else {
            return htmlspecialchars($value);
        }
    }

    
?>