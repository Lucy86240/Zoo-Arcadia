<?php 

include_once "Controller/ManageAnimal.php";

function allAnimals(){
    $animals = [];
    $animalsObject = AnimalsExtract(2,-1,0,0);
    foreach($animalsObject as $animalObject){
        $animal['id'] = $animalObject->getId();
        $animal['name'] = $animalObject->getName();
        $animal['breed'] = $animalObject->getBreed();
        $animal['housing'] = $animalObject->getIdHousing();
        $animal['photo'] = $animalObject->getImage(0);
        if($animalObject->countImages()>0){
            $animal['photo']=[];
            $animal['photo']['path'] = $animalObject->getImage(0)->getPath();
            $animal['photo']['description'] = $animalObject->getImage(0)->getDescription();
        } else{
            $animal['photo']=[];
            $animal['photo']['path'] = IMG_DEFAULT_ANIMAL;
            $animal['photo']['description'] = "";
        }
        array_push($animals,$animal);
    }
    return $animals;
}

function colorhousing(int $id){
    $colors=["beige","blue","green","brown","dark_green"];
    $housings= listIdAllHousings();
    $i=array_search($id,$housings);
    if($i%5==0) return $colors[4];
    if($i%4==0) return $colors[3];
    if($i%3==0) return $colors[2];
    if($i%2==0) return $colors[1];
    else return $colors[0];
}

$animals = allAnimals();