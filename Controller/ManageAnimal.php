<?php

include_once "Model/ManageAnimalModel.php";

function changeAnimalObjectToAssociatif(Animal $animalObject){
    $animal = array(
        "name" => $animalObject->getName(),
        "housing" => $animalObject->getHousing(),
        "breed" => $animalObject->getBreed(),
        "IsVisible" => $animalObject->getIsVisible(),
        'LastMedicalReport' => array(
            "date" => $animalObject->getLastMedicalReport()['date'],
            "health" => $animalObject->getLastMedicalReport()['health'],
            "food" => $animalObject->getLastMedicalReport()['food'],
            "weightFood" => $animalObject->getLastMedicalReport()['weight_of_food'],
            "comment" => $animalObject->getLastMedicalReport()['comment'],

        ),
    );
    $animal['images'] = [];
    for($i=0 ; $i<$animalObject->countImages(); $i++){
        $img= array(
            "path" => $animalObject->getImage($i)->getPath(),
            "description" => $animalObject->getImage($i)->getDescription(),
        );
        array_push($animal['images'],$img);
    }
    if($animal['images']==[]){
        $img= array(
            "path" => IMG_DEFAULT_ANIMAL,
            "description" => 'pas de photo disponible',
        );
        array_push($animal['images'],$img);
    }

    return $animal;
}

function animalsView(int $justVisibleAnimal, int $nbAnimals, int $currentPage, bool $medicalDetail){
    $animalsObject = animalsExtract($justVisibleAnimal,$nbAnimals,$currentPage,$medicalDetail);
    $animals = [];
    foreach($animalsObject as $animalObject){
        $animal = changeAnimalObjectToAssociatif($animalObject);
        array_push($animals,$animal);
    }
    
    return $animals;
}
    $animals= animalsView(1,1,1,1);
    $animal = $animals[0];
    var_dump($animal);