<?php

include_once "Model/Animal.php";
include_once "Model/MedicalReport.php";

/**
 * Summary of countAnimals : indique le nombre d'animal présent dans un habitat
 * @param mixed $justVisibleAnimal : si 0 = animal archivé (non visible par les visiteurs), 1 : visible, 2 : tous
 * @param int $id_housing : identifiant de l'habitat des animaux à compter
 * @return mixed
 */
function countAnimals($justVisibleAnimal, int $id_housing){
    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
    if($justVisibleAnimal==0 || $justVisibleAnimal==1){
        $visible = "WHERE isVisible = ".$justVisibleAnimal." ";
    }
    else{
        $visible = "";
    }
    $request = 'SELECT count(*) FROM animals '.$visible;
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
    function findAnimalsByHousing(int $id_housing, int $nbAnimals=-1, int $currentPage, int $justVisibleAnimal=1,bool $portraitAccept=true){
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
            $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);
        }      
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

/**
 * Summary of animalExistById : indique si un animal a l'identifiant mis en paramètre
 * @param int $id
 * @return bool
 */
function animalExistById(int $id){
    $animal = findAnimalById($id);
    if($animal == null) return false;
    else return true;
}

/**
 * Summary of listAllBreeds : retourne la liste de toutes les races de la base de données sous forme de tableau associatif
 * @return array|string
 */
function listAllBreeds(){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM breeds');
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch(Error $e){
        echo "Désolée";
        return '';
    }
}

/**
 * Summary of breedExist
 * @param string $breed
 * @return int : retourne -1 s'il n'existe pas, -2 en cas de problème de base de données sinon retourne l'id
 *  */
function breedExistByName(string $breed){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT id_breed FROM breeds WHERE label = :breed');
        $stmt->bindParam(":breed", $breed, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res == null) return -1;
        else return $res['id_breed'];
    }
    catch(error $e){
        echo('erreur de bd');
        return -2;
    }
}

function breedExistById(int $id){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM breeds WHERE id_breed = :breed');
        $stmt->bindParam(":breed", $id, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res == null) return false;
        else return true;
    }
    catch(error $e){
        echo('erreur de bd');
        return true;
    }
}

/**
 * Summary of addBreedRequest : ajoute une race à la base de donnée
 * @param string $newBreed : nom de la race à ajouter
 * @return int : retourne l'id de la nouvelle race créée
 */
function addBreedRequest(string $newBreed){
    //vérifie que la race n'existe pas
    if(breedExistByName($newBreed)==-1){
        //on ajoute la race
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('insert into breeds (label) VALUES (:label)');
        $stmt->bindParam(":label", $newBreed, PDO::PARAM_STR);
        $stmt->execute();
        return breedExistByName($newBreed);
    }else{
        return breedExistByName($newBreed);
    }
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

function archiveAnimalRequest(int $id){
    try{
        //on vérifie que le service existe et qu'il y a une modification à faire
        if(animalExistById($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('UPDATE animals SET isVisible = 0 WHERE id_animal = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return "success";
    }
    catch(error $e){
        echo('erreur bd');
        return "error";
    }
}

function unarchiveAnimalRequest(int $id){
    try{
        //on vérifie que le service existe et qu'il y a une modification à faire
        if(animalExistById($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('UPDATE animals SET isVisible = 1 WHERE id_animal = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return "success";
    }
    catch(error $e){
        echo('erreur bd');
        return "error";
    }
}

function updateAnimalRequest(int $id,string $name, int $housing, int $breed){
    try{
        //on vérifie que le service existe et qu'il y a une modification à faire
        if(animalExistById($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            //on adapte la requête suivant la/les modifications à effectuer
            //si on modifie l'intitulé et la description
            if($name != '0' ){
                $stmt = $pdo->prepare('UPDATE animals SET name = :name WHERE id_animal = :id');
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            if($housing > 0){
                $stmt = $pdo->prepare('UPDATE animals SET housing = :housing WHERE id_animal = :id');
                $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            if(breedExistById($breed)>0){
                $stmt = $pdo->prepare('UPDATE animals SET breed = :breed WHERE id_animal = :id');
                $stmt->bindParam(":breed", $breed, PDO::PARAM_INT);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        return "success";
    }
    catch(error $e){
        echo('erreur bd');
        return "error";
    }
}