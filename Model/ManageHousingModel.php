<?php
    //include_once '../config.php';
    include_once "Model/Housing.php";
    include_once "Model/Animal.php";
    include_once "Model/ManageAnimalModel.php";
    include_once "Model/Image.php";
    include_once "Model/CommentHousing.php";
    function AllHousings(bool $portraitAccept=true){
        try{
            $housings = [];
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
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
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM housings WHERE id_housing = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $housing;
    }

//    public function FindHousingByName(string $name){
    function FindHousingByName(string $name){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM housings WHERE name = :name');
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->execute();
            $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $housing[0];
        }
        catch(Error $e){
            echo "Désolée";
            return new Housing();
        }
    }

    function listNameIdAllHousings(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT name, id_housing FROM housings');
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(Error $e){
            echo "Désolée";
            return '';
        }
    }

function commentHousing(int $housing,$archive){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $request='';
        if($archive==1 || $archive==0){
            $request=' AND archive='.$archive;
        }
        $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto WHERE housing= :housing'.$request);
        $stmt->bindParam(':housing',$housing,PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS,'CommentHousing');
        return $res;
    }
    catch(Error $e){
        echo "Désolée";
        return '';
    }
}