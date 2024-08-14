<?php

include_once "Model/ManageAnimalModel.php";
include_once 'Model/ManageHousingModel.php';

/**
 * Summary of changeAnimalObjectToAssociatif : prend un objet animal et le change en tableau asso
 * @param Animal $animalObject 
 * @param bool $allReport : true si l'on souhaite que le tableau contienne tous les rapports médicaux
 * @return array
 */
function changeAnimalObjectToAssociatif(Animal $animalObject, bool $allReport, bool $foods){
    if(animalExistById(($animalObject->getId()))){
        $animal = array(
            "id" => $animalObject->getId(),
            "name" => $animalObject->getName(),
            "housing" => $animalObject->getHousing(),
            "breed" => $animalObject->getBreed(),
            "isVisible" => $animalObject->getIsVisible(),
            "numberReports" => $animalObject->countMedicalReports(),
            "numberFoods" => $animalObject->countFoods()
        );
        if($animalObject->getLastMedicalReport() != null){
            $animal['LastMedicalReport'] = array(
                "date" => date("d/m/Y",strtotime($animalObject->getLastMedicalReport()->getDate())),
                "health" => $animalObject->getLastMedicalReport()->getHealth(),
                "food" => $animalObject->getLastMedicalReport()->getFood(),
                "weight_of_food" => $animalObject->getLastMedicalReport()->getWeightOfFood(),
                "comment" => $animalObject->getLastMedicalReport()->getComment(),
            );
            $animal['LastMedicalReport']["veterinarian"] = findNameofUser($animalObject->getLastMedicalReport()->getIdVeterinarian());
        }
        if($allReport == true && $animalObject->getLastMedicalReport() != null){
            $animal['reports'] = [];
            for($i=0; $i<$animalObject->countMedicalReports();$i++){
                $report = array(
                    "date" => $animalObject->getMedicalReport($i)->getDate(),
                    "health" => $animalObject->getMedicalReport($i)->getHealth(),
                    "food" => $animalObject->getMedicalReport($i)->getFood(),
                    "weight_of_food" => $animalObject->getMedicalReport($i)->getWeightOfFood(),
                    "comment" => $animalObject->getMedicalReport($i)->getComment(),
                );
                $report['veterinarian']= findNameofUser($animalObject->getMedicalReport($i)->getIdVeterinarian());
                array_push($animal['reports'],$report);
            }
        }
        $animal['images'] = [];
        for($i=0 ; $i<$animalObject->countImages(); $i++){
            $img= array(
                "path" => $animalObject->getImage($i)->getPath(),
                "description" => $animalObject->getImage($i)->getDescription(),
                "id" => $animalObject->getImage($i)->getId(),
            );
            array_push($animal['images'],$img);
        }
        if($animal['images']==[]){
            $img= array(
                "path" => IMG_DEFAULT_ANIMAL,
                "description" => 'pas de photo disponible',
                "id" => 0,
            );
            array_push($animal['images'],$img);
        }

        if($foods){
            $animal['foods'] = [];
            for($i=0; $i<$animalObject->countFoods();$i++){
                $food = array(
                    "date" => $animalObject->getFoods($i)->getDate(),
                    "hour" => $animalObject->getFoods($i)->getHour(),
                    "food" => $animalObject->getFoods($i)->getFood(),
                    "weight" => $animalObject->getFoods($i)->getWeight(),
                );
                $food['employee']= findNameofUser($animalObject->getFoods($i)->getIdEmployee());
                array_push($animal['foods'],$food);
            }
        }
        return $animal;
    }
    else return [];
}

/**
 * Summary of animalsView retourne un tableaux associatifs avec des informations d'animaux
 * @param int $justVisibleAnimal : indiquer si les animaux doivent être visibles (2 si peut importe)
 * @param int $nbAnimals : nombre d'animaux souhaité (-1 si tous)
 * @param int $currentPage : utile si plusieurs pages (indique quelle page on souhaite)
 * @param bool $medicalDetail : true si on veut le détail des avis médicaux
 * @return array
 */
function animalsView(int $justVisibleAnimal, int $nbAnimals, int $currentPage, bool $medicalDetail){
    $animalsObject = animalsExtract($justVisibleAnimal,$nbAnimals,$currentPage,$medicalDetail);
    $animals = [];
    foreach($animalsObject as $animalObject){
        if($animalObject != null) $animal = changeAnimalObjectToAssociatif($animalObject, false,false);
        else $animal=null;
        array_push($animals,$animal);
    }
    
    return $animals;
}

/**
 * Summary of animalById: retourne un tableau associatif avec les infos de l'animal ayant l'id entré en paramétre
 * @param int $id : id de l'animal souhaité
 * @param mixed $allReport : true si l'on souhaite avoir les avis médicaux
 * @return array|null
 */
function animalById(int $id, $allReport, $foods){
    $animalObject=findAnimalById($id);
    //var_dump($animalObject);
    if($animalObject!=null) $animal = changeAnimalObjectToAssociatif($animalObject, $allReport, $foods);
    else $animal = null;
    return $animal;
}

/**
 * Summary of deleteService : permet de supprimer un service
 * @param int $id : id du service à supprimer
 * @return void
 */
function deleteAnimal(int $id, string $name, $id_housing){
    //on recupère le nom du bouton à cliquer pour supprimer le service
    $nameButton = "ValidationDeleteAnimal".$id;
    //si on a cliqué sur le bouton
    if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
        //suppression dans la base de données
        deleteAnimalRequest($id);
        //suppression des images
        $path = "View/assets/img/animals/".$id.'-'.$name.'/';
        rrmdir($path);
        $_SESSION['animal'.$id_housing] = null;
        $_POST[$nameButton]=null;
    } 
    
}

function deleteAnimalWithoutForm(Animal $animal){
        //suppression dans la base de données
        deleteAnimalRequest($animal->getId());
        //suppression des images
        $path = "View/assets/img/animals/".$animal->getId().'-'.$animal->getname().'/';
        rrmdir($path);
        $_SESSION['animal'.$animal->getIdHousing()] = null;
}

function archiveAnimal(&$animal){
    //on recupère le nom du bouton à cliquer pour supprimer le service
    $nameButton = "ValidationArchiveAnimal".$animal['id'];
    //si on a cliqué sur le bouton
    if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
        //suppression dans la base de données
        archiveAnimalRequest($animal['id']);
        $_POST[$nameButton]=null; 
        $animal = changeAnimalObjectToAssociatif(findAnimalById($animal['id']), true, true);
    } 
    
}
function unarchiveAnimal(&$animal){
    //on recupère le nom du bouton à cliquer pour supprimer le service
    $nameButton = "ValidationUnarchiveAnimal".$animal['id'];
    //si on a cliqué sur le bouton
    if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
        //suppression dans la base de données
        unarchiveAnimalRequest($animal['id']);
        $_POST[$nameButton]=null;
        $animal = changeAnimalObjectToAssociatif(findAnimalById($animal['id']), true,true);
    } 
    
}

function echoAnimal($id,$page){
    //on cherche mes info de l'animal
    $animal = animalById($id,false,false);
    //var_dump($animal);
    //on trouve l'id de son habitat et on sauve l'animal via une variable de session (pour pages habitats)
    $housing=FindHousingByName($animal['housing']);
    if($page=='housings') $_SESSION['animal'.$housing["id_housing"]] = $animal['id'];
    if($page=='allAnimals') $_SESSION['allAnimals_animalSelected'] = $animal['id'];

    //on permet la suppression / l'archivage / le désarchivage
    deleteAnimal($animal['id'],$animal['name'],$housing["id_housing"]);
    archiveAnimal($animal);
    unarchiveAnimal($animal);

    //on affiche les infos
    include "View/elements/animal.php";
}