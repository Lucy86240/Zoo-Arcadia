<?php
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
function allHousingsView(bool $id=false, bool $description=true, int $nbImgs=-1, int $nbAnimals=0, int $justVisibleAnimals=1, bool $portraitAccept=true){
        $housingsObject = AllHousings($portraitAccept);
        $housings = [];
        $id=0;
        foreach($housingsObject as $housingObject){ 
            $housing = array(
                "name" => $housingObject->getName(),
                "color" => $housingObject->getcolorTheme(),
                "id" => $housingObject->getId(),
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
                $animalsObject = findAnimalsByHousing($housingObject->getId(), $nbAnimals,1, $justVisibleAnimals,$portraitAccept);
                $housing["animals"] =[];
                foreach($animalsObject as $animalObject){
                    $animal = array(
                        "id" => $animalObject->getId(),
                        "name" => $animalObject->getName(),
                        "breed" => $animalObject->getBreed(),
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

            //ajout des commentaires
            $commentsObject = commentHousing($housing['id'],0);
            $housing['comments']=[];
            foreach($commentsObject as $commentObject){
                $comment=array(
                    "idComment" => $commentObject->getId(),
                    "comment" => $commentObject->getComment(),
                    "date" => $commentObject->getDate(),
                    "veterinarian" => findNameOfUser($commentObject->getVeterinarian()),
                );
                array_push($housing['comments'],$comment);
            }

            $housings[$id]=$housing;
            $id++;
        }            
    return $housings;
}
