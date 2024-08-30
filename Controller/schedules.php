<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/schedules.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    try{
        require_once "Model/schedules.php";
        //on récupère le texte des horaires
        $schedules=schedules();
    }
    catch(error $e){
        $schedules='Oups nous ne trouvons pas les horaires...';
    }
}