<?php
//si on est sur un url différent du chemin du fichier on execute le programme
if($_SERVER['REQUEST_URI']!='/Controller/homeController.php'){
    try{
        //on récupère les infos des habitats pour la section habitat
        require_once "Controller/ManageHousing.php";
        //on récupère les infos des services pour la section services
        //require_once "Controller/ManageService.php";
        //on récupère les infos des avis pour la section avis
        //require_once "Controller/ManageReview.php";
    }catch(error $e){
        echo('oups un fichier est manquant');
    }

}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}