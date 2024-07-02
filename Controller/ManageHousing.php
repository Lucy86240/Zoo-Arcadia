<?php
    //include_once '../config.php';
    include_once "Model/ManageHousingModel.php";

/**
 * Retourne un tableau associatif avec au moins tout les noms des habitats
 * @param $id true ajoute l'id au tableau
 * @param $description true ajoute la description au tableau
 * @param $nbImgs ajoute les chemins, descriptions du nombre d'image indiquées
 * @param $nbAnimals ajoute les éléments d'autant d'animal que souhaité (-1 = all)
 * @param $justVisibleAnimals 1: animaux visibles, 0: animaux non visibles, 2: tous
 * @param $portraitAccept si les images en portrait sont acceptées (par défaut true)
 */
    function AllHousingsView(bool $id=false, bool $description=true, int $nbImgs=-1, int $nbAnimals=0, int $justVisibleAnimals=1, bool $portraitAccept=true){
        $housingsObject = AllHousings($portraitAccept);
        $housings = [];
        $id = 0;
        foreach($housingsObject as $housingObject){ 
            $housing = array(
                "name" => $housingObject->getName(),
            );
            if($description == true){
                $housing["description"] = $housingObject->getDescription();
            }

            //ajout du nombre d'images souhaitées
            if ($nbImgs == -1 || $nbImgs > $housingObject->countImages() ){
                $nb = $housingObject->countImages();
            }
            else{
                $nb = $nbImgs;
            }
            $housing['images'] = [];
            for($i=0 ; $i<$nb; $i++){
                $img= array(
                    'path' => $housingObject->getImage($i)->getPath(),
                    'description' => $housingObject->getImage($i)->getDescription(),
                );
                array_push($housing['images'],$img);
            }
            if($housing['images'] == []){
                $img= array(
                    'path' => IMG_DEFAULT_HOUSING,
                    'description' => "photo indisponible",
                );
                array_push($housing['images'],$img);
            }
            

            //ajout du nombre d'animaux souhaités
            if ($nbAnimals != 0)
            {
                $animalsObject = FindAnimalsByHousing($housingObject->getId(), $nbAnimals, $justVisibleAnimals,$portraitAccept);
                $housing["animals"] =[];
                foreach($animalsObject as $animalObject){
                    $animal = array(
                        "name" => $animalObject->getName(),
                        "breed" => $animalObject->getBreed(),
                        "health" => $animalObject->getHealth(),
                        "IsVisible" => $animalObject->getIsVisible(),
                    );
                    $animal['imagesAnimals'] = [];
                    for($i=0 ; $i<$animalObject->countImages(); $i++){
                        $img= array(
                            "pathAnimals" => $animalObject->getImage($i)->getPath(),
                            "descriptionAnimals" => $animalObject->getImage($i)->getDescription(),
                        );
                        array_push($animal['imagesAnimals'],$img);
                    }
                    if($animal['imagesAnimals']==[]){
                        $img= array(
                            "pathAnimals" => IMG_DEFAULT_ANIMAL,
                            "descriptionAnimals" => 'pas de photo disponible',
                        );
                        array_push($animal['imagesAnimals'],$img);
                    }
                    array_push($housing["animals"],$animal);
                }
            }

            $housings[$id]=$housing;
            $id++;
        }            
    return $housings;
    }