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

function defaultValueCheckbox(string $filter, $value){
    if(isset($_POST[$filter])) return 'checked';
    else{
        if(!isset($_POST['choices'])){
            if(substr($filter,0,13)=="breedSelected"){
                if(isset($_SESSION['allAnimals_filterBreeds'])){
                    $ind = array_search($value,$_SESSION['allAnimals_filterBreeds'],true);
                    if(isset($_SESSION['allAnimals_filterBreeds'][$ind]) && $_SESSION['allAnimals_filterBreeds'][$ind]==$value) return 'checked';
                    else return '';
                } 
                else return '';
            }
        }
        else return '';
    }
}

$animals = allAnimals();