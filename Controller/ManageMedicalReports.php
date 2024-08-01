<?php

include_once "Controller/ManageAnimal.php";

function urlFilter(){
    $url ='';
        if(isset($_POST['choices']) && isset($_POST['limit'])){
            $url.='&limit='.$_POST['limit'];
        }
        else if(isset($_GET['limit'])){
            $url.='&limit='.$_GET['limit'];
        }
}

$animal = null;
if(isset($_GET['animal'])){
    $animal=animalById($_GET['animal'],true);
}
else
{
    echo("Nous n'arrivons pas à trouver l'animal");
}