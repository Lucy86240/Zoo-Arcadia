<?php
//si on est sur un url différent du chemin du fichier on execute le programme
if($_SERVER['REQUEST_URI']!='/Controller/HomeController.php'){
    //on récupère les infos des habitats pour la section habitat
    include_once "Controller/ManageHousing.php";
    //on récupère les infos des services pour la section services
    include_once "Controller/ManageService.php";
    //on récupère les infos des avis pour la section avis
    include_once "Controller/ManageReview.php";
}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}