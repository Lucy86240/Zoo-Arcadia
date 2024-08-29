<?php
//on execute le programme si on est sur un url différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/attributions.php'){
    require_once "Model/Image.php";
    //on récupère les attributions des images
    $attributions = listAttributions();
}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
