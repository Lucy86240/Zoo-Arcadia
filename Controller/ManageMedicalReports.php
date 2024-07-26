<?php

include_once "Controller/ManageAnimal.php";

$animal = null;
if(isset($_GET['animal'])){
    $animal=animalById($_GET['animal'],true);
}
else
{
    echo("Nous n'arrivons pas à trouver l'animal");
}