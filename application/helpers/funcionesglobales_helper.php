<?php

if (!function_exists("numero_categoria")){
    function numero_categoria($categoria){
        switch ($categoria){
            case "usuarios":
                return 1;
            case "eventos":
                return 2;
            case "noticias":
                return 3;  
            case "corporativo":
                return 4;
            default:
                return 99;
        }
    }
};


?>