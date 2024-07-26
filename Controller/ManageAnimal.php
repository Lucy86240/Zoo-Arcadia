<?php

include_once "Model/ManageAnimalModel.php";

function changeAnimalObjectToAssociatif(Animal $animalObject, bool $allReport){
        $animal = array(
            "id" => $animalObject->getId(),
            "name" => $animalObject->getName(),
            "housing" => $animalObject->getHousing(),
            "breed" => $animalObject->getBreed(),
            "IsVisible" => $animalObject->getIsVisible(),
        );
        if($animalObject->getLastMedicalReport() != null){
            $animal['LastMedicalReport'] = array(
                "date" => $animalObject->getLastMedicalReport()['date'],
                
                "health" => $animalObject->getLastMedicalReport()['health'],
                "food" => $animalObject->getLastMedicalReport()['food'],
                "weightFood" => $animalObject->getLastMedicalReport()['weight_of_food'],
                "comment" => $animalObject->getLastMedicalReport()['comment'],
            );
            $animal['LastMedicalReport']["veterinarian"] = findNameofUser($animalObject->getLastMedicalReport()['veterinarian']);

        }
        if($allReport == true && $animalObject->getLastMedicalReport() != null){
            $animal['reports'] = [];
            for($i=0; $i<$animalObject->countMedicalReports();$i++){
                $report = array(
                    "date" => $animalObject->getMedicalReport($i)['date'],
                    "health" => $animalObject->getMedicalReport($i)['health'],
                    "food" => $animalObject->getMedicalReport($i)['food'],
                    "weightFood" => $animalObject->getMedicalReport($i)['weight_of_food'],
                    "comment" => $animalObject->getMedicalReport($i)['comment'],
                );
                $report['veterinarian']= findNameofUser($animalObject->getMedicalReport($i)['veterinarian']);
                array_push($animal['reports'],$report);
            }
        }
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
        if($animalObject != null) $animal = changeAnimalObjectToAssociatif($animalObject, false);
        else $animal=null;
        array_push($animals,$animal);
    }
    
    return $animals;
}

function animalById(int $id, $allReport){
    $animalObject=findAnimalById($id);
    if($animalObject!=null) $animal = changeAnimalObjectToAssociatif($animalObject, $allReport);
    else $animal = null;
    return $animal;
}

/**
 * Summary of deleteService : permet de supprimer un service
 * @param int $id : id du service à supprimer
 * @return void
 */
function deleteAnimal(int $id, string $name){
    //on recupère le nom du bouton à cliquer pour supprimer le service
    $nameButton = "ValidationDeleteAnimal".$id;
    //si on a cliqué sur le bouton
    if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
        //suppression dans la base de données
        deleteAnimalRequest($id);
        //suppression des images
        $path = "View/assets/img/animals/".$id.'-'.$name.'/';
        rrmdir($path);
        $_POST[$nameButton]=null;
    } 
    
}

    $animals= animalsView(1,1,1,1);
    $animal = $animals[0];
    deleteAnimal($animal['id'],$animal['name']);