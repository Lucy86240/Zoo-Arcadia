<?php

include_once "Controller/ManageAnimal.php";

function housingsPopularity(){
$housingsObject= housingsOrderByPopularity();
$housings=[];
if(count($housingsObject)>3)$lenght=3;
else $lenght = count($housingsObject);
for($i=0;$i<$lenght;$i++){
    $housing = array(
        "name" => $housingsObject[$i]->getName(),
        "pathImg" => $housingsObject[$i]->getImage(0)->getPath(),
        "numberClics" => $housingsObject[$i]->getNumberOfClics(),
    );
    array_push($housings,$housing);
}

return $housings;

}

$animals = animalsWithPopularity();
$housings =  housingsPopularity();
