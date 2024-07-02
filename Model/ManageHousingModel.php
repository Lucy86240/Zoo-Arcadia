<?php
    //include_once '../config.php';
    include_once "Model/Housing.php";
    include_once "Model/Animal.php";
    include_once "Model/Image.php";
    function AllHousings(bool $portraitAccept=true){
        try{
            $housings = [];
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
            $stmt = $pdo->prepare('SELECT * FROM housings');
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Housing');
            if($stmt->execute()){
                while($housing = $stmt->fetch()){
                    array_push($housings,$housing);
                    $indice=count($housings)-1;
                    $id = $housings[$indice]->getId();
                    if($portraitAccept == false){
                        $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_housings JOIN images ON images_housings.id_image = images.id_image  WHERE id_housing = :id and images.portrait=0');
                    }
                    else{
                        $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_housings JOIN images ON images_housings.id_image = images.id_image  WHERE id_housing = :id');
                    }
                    $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                    if ($stmt2->execute())
                    {
                        while($image = $stmt2->fetch()){
                                $housings[$indice]->addImage($image);
                        }
                    }
                }
            }
            return $housings;
        }
        catch (error $e){
            echo "Désolée";
            return new Housing();
        }
    }

//    public function FindHousingByid(int $id){
    function FindHousingByid(int $id){
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT * FROM housings WHERE id_housing = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $housing;
    }

//    public function FindHousingByName(string $name){
    function FindHousingByName(string $name){
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
            $stmt = $pdo->prepare('SELECT * FROM housings WHERE name = :name');
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->execute();
            $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $housing;
        }
        catch(Error $e){
            echo "Désolée";
            return new Housing();
        }
    }

    /**
     * @param $id_housing 
     * @param $nbAnimals numbers of animals, -1 = all
     * @param $justVisibleAnimal 1: animaux visibles, 0: animaux non visibles, 2: tous
     * @param $portraitAccept si les images en portrait sont acceptées (par défaut true)
     * @return $animals array of animals
     */
    function FindAnimalsByHousing(int $id_housing, int $nbAnimals=-1, int $justVisibleAnimal=1,bool $portraitAccept=true){
        try{
            $animals = [];
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
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

//}