<?php
//on execute le programme si on est sur un url différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/attributions.php'){
    try{
        require_once "Model/Image.php";
        //on récupère les attributions des images
        $attributions = listAttributions();
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page attribution...');
    }
}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
