<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/updateSchedules.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once 'Controller/schedules.php';
        //après validation du formulaire on modifie 
        if(isset($_POST['schedules'])){
            modifySchedules($_POST['schedules']);
        }

}