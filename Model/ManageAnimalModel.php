<?php

include_once "Model/Animal.php";
include_once "Model/MedicalReport.php";


function countAnimals($justVisibleAnimal, int $id_housing){
    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
    if($justVisibleAnimal==0 || $justVisibleAnimal==1){
        $visible = "isVisible = ".$justVisibleAnimal." ";
    }
    else{
        $visible = "isVisible = 1 AND isVisible = 0 ";
    }
    $request = 'SELECT count(*) FROM animals WHERE '.$visible;
    if($id_housing >0) $request." id_housing = .".$id_housing;

    $stmt = $pdo->prepare($request);


    if($stmt->execute()){
        $res = $stmt->fetch();
        return $res[0];
    }
    else{
        return 0;
    }
}

/**
     * @param $id_housing 
     * @param $nbAnimals numbers of animals, -1 = all
     * @param $currentPage sert pour la pagination
     * @param $justVisibleAnimal 1: animaux visibles, 0: animaux non visibles, 2: tous
     * @param $portraitAccept si les images en portrait sont acceptées (par défaut true)
     * @return $animals array of animals
     */
    function FindAnimalsByHousing(int $id_housing, int $nbAnimals=-1, int $currentPage, int $justVisibleAnimal=1,bool $portraitAccept=true){
        try{
            $animals = [];
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            if($nbAnimals<1){
                if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                    $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id and isVisible = :visible');
                    $stmt->bindParam(":visible", $justVisibleAnimal, PDO::PARAM_INT);
                }
                else{
                    $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id');
                }
            }
            else{
                    if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                        $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id and isVisible = :visible ORDER BY id_animal LIMIT :limit');
                        $stmt->bindParam(":visible", $justVisibleAnimal);                     
                    }
                    else{
                        $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id ORDER BY id_animal LIMIT :limit');
                    }
                    
                    $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);
            }

            $stmt->bindParam(":id", $id_housing, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');

            if($stmt->execute()){
                while($animal = $stmt->fetch()){
                    array_push($animals,$animal);
                    //add images
                    $indice=count($animals)-1;
                    $id = $animals[$indice]->getId();
                    if($portraitAccept==false){
                        $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id and images.portrait = 0');
                    }
                    else{
                        $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id');
                    }
                    $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                    if ($stmt2->execute())
                    {
                        while($image = $stmt2->fetch()){
                                $animals[$indice]->addImage($image);
                        }
                    }
                }
            }
            return $animals;
        }
        catch(error $e){

        }
}

/**
 * Summary of AnimalsExtract
 * @param int $justVisibleAnimal : 1 = animaux visible seulement , 0 = animaux invisible (archivé), 2 = tous
 * @param int $nbAnimals : nombre d'animaux retourné / -1 = all
 * @param int $currentPage : en cas de pagination
 * @param bool $medicalDetail : false = les rapports médicaux ne sont pas extraits
 * @return array
 */
function AnimalsExtract(int $justVisibleAnimal, int $nbAnimals, int $currentPage, bool $medicalDetail){
    try{
        $animals = [];
        if($nbAnimals < 0 || $nbAnimals>countAnimals($justVisibleAnimal,-1)) $nbAnimals = countAnimals($justVisibleAnimal,-1);
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        if($justVisibleAnimal==0 || $justVisibleAnimal==1){
            $stmt = $pdo->prepare('SELECT * FROM animals WHERE isVisible = :visible ORDER BY id_animal ASC LIMIT :limit');
            $stmt->bindParam(":visible", $justVisibleAnimal, PDO::PARAM_INT);       
            $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);        
        }
        else{
            $stmt = $pdo->prepare('SELECT * FROM animals ORDER BY id_animal ASC LIMIT :limit');
        }      
        $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);
        //$stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            while($animal = $stmt->fetch()){
                $animalObject = new Animal();
                $animalObject->setId($animal['id_animal']);
                $animalObject->setName($animal['name']);
                $animalObject->setIdBreed($animal['breed']);
                $animalObject->setIdHousing($animal['housing']);
                $animalObject->setIsVisible($animal['isVisible']);
                array_push($animals,$animalObject);
                //add images
                $indice=count($animals)-1;
                $id = $animals[$indice]->getId();
                $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id');
                $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                if ($stmt2->execute())
                {
                    while($image = $stmt2->fetch()){
                        $animals[$indice]->addImage($image);
                    }
                }
                if ($medicalDetail==1){
                    $request = 'SELECT * FROM reports_veterinarian WHERE animal = '.$id.' ORDER BY date DESC';
                    $stmt3 = $pdo->prepare($request);
                    $stmt2->setFetchMode(PDO::FETCH_CLASS,'MedicalReport');
                    if ($stmt3->execute())
                    {
                        while($report = $stmt3->fetch()){
                            $animals[$indice]->addMedicalReport($report);
                        }
                    }
                }
        
            }
        }
        return $animals;
    }
    catch(error $e){
        echo('erreur');
        return [];
    }
}

function findAnimalById(int $id){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM animals WHERE id_animal = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');

        if($stmt->execute()){
            $animal = $stmt->fetch();
            //add images
            $id = $animal->getId();
            $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
            FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id and images.portrait = 0');
            $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
            if ($stmt2->execute())
            {
                while($image = $stmt2->fetch()){
                    $animal->addImage($image);
                }
            }
            $request = 'SELECT * FROM reports_veterinarian WHERE animal = '.$id.' ORDER BY date DESC';
            $stmt3 = $pdo->prepare($request);
            $stmt2->setFetchMode(PDO::FETCH_CLASS,'MedicalReport');
            if ($stmt3->execute())
            {
                while($report = $stmt3->fetch()){
                    $animal->addMedicalReport($report);
                }
            }
        }
        return $animal;
    }
    catch(error $e){

    }
}

function animalExistById(int $id){
    $animal = findAnimalById($id);
    if($animal == null) return false;
    else return true;
}

/**
 * Summary of deleteServiceRequest : supprime un service dans la base de données
 * @param int $id : id du service à supprimer
 * @return void
 */
function deleteAnimalRequest(int $id){
    try{
        if(animalExistById($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);

            //on cherche toutes les images associées à l'animal
            $stmt = $pdo->prepare('SELECT id_image FROM images_animals WHERE id_animal = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //on supprime toutes les images
            if($res != null){
               // var_dump($res);
                foreach ($res as $id_image){
                    $stmt = $pdo->prepare('DELETE FROM images WHERE id_image = :id');
                    $stmt->bindParam(":id", $id_image['id_image'], PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            //on supprime l'animal
            $stmt = $pdo->prepare('DELETE FROM animals WHERE id_animal = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    catch(error $e){
        echo("problème avec les données");
    }
}