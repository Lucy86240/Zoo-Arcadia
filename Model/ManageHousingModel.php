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
            if ($housing != null) return $housing[0];
            else null;
        }
        catch(Error $e){
            echo "Désolée";
            return null;
        }
    }

    function findHousingNameById(int $id){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT name FROM housings WHERE id_housing = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $housing[0]['name'];
        }
        catch(Error $e){
            echo "Désolée";
            return '';
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

    function housingExist(Housing $housing){
        $name = $housing->getName();
        if (FindHousingByName($name) != null) return true;
        else return false;
    }
    function housingExistById(int $id){
        if (FindHousingById($id) != null) return true;
        else return false;
    }

    function addHousingRequest(Housing $housing,&$id){
        try{
            if(housingExist($housing)==false){
                //ajoute les éléments dans la table housing
                $name = $housing->getName();
                $description = $housing->getDescription();
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('insert into housings (name, description) VALUES (:name, :description)');
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                $stmt->execute();
    
                //recherche l'id de l'habitat créé
                $stmt = $pdo->prepare('SELECT id_housing FROM housings WHERE name = :name and description = :description');
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $res['id_housing'];
                return 'success';
            }
            else{
                return 'error';
            }
        }
        catch(error $e){
            echo("problème avec les données");
            return 'error';
        }
    }

    function updateHousingRequest(int $id,$name,$description){
        try{
            //on vérifie que l'habitat existe et qu'il y a une modification à faire
            if(housingExistById($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                if($name != '0' ){
                    $stmt = $pdo->prepare('UPDATE housings SET name = :name WHERE id_housing = :id');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
    
                if($description != '0'){
                    $stmt = $pdo->prepare('UPDATE housings SET description = :description WHERE id_housing = :id');
                    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
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

    function deleteHousingRequest($id){
        try{
            if(housingExistById($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);

                //on cherche toutes les images associées à l'habitat
                $stmt = $pdo->prepare('SELECT id_image FROM images_housings WHERE id_housing = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                //on supprime toutes les images
                if($res != null){
                    foreach ($res as $id_image){
                        $stmt = $pdo->prepare('DELETE FROM images WHERE id_image = :id');
                        $stmt->bindParam(":id", $id_image['id_image'], PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
    
                //on supprime l'habitat
                $stmt = $pdo->prepare('DELETE FROM housings WHERE id_housing = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        catch(error $e){
            echo("problème avec les données");
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

/**
 * Summary of allCommentsRequest
 * @param mixed $housing peut être null sinon tableau d'id
 * @param mixed $dateStart peut être null
 * @param mixed $dateEnd peut être null
 * @param mixed $status : 1 = archivé 0 = actif 2 = tous
 * @return array
 */
function allCommentsRequest($housing,$dateStart,$dateEnd,$status){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $request='';
        if($housing != null || $dateEnd !=null || $dateStart != null || $status != null){
            $request="WHERE";
            if($housing !=null){
                $request.=' housing='.$housing[0];
                for ($i=1; $i < count($housing); $i++){
                    $request.=' OR housing='.$housing[$i];
                }
            }
            if(($status==1 || $status==0) && $status != null){
                if($request != "WHERE") $request.= " AND";
                $request.=' archive='.$status;
            }
            if($dateStart != null){
                if($request != "WHERE") $request.= " AND";
                $request.=' date >= \"'.$dateStart."\"";
            }
            if($dateEnd != null){
                if($request != "WHERE") $request.= " AND";
                $request.=' date >= \"'.$dateEnd."\"";
            }
        }
        $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto '.$request.' ORDER BY date DESC');
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS,'CommentHousing');
        return $res;
    }
    catch(Error $e){
        echo "Désolée";
        return [];
    }
}

function commentExist($veto, $date, $housing, $comment){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto 
        WHERE comment = :comment AND housing = :housing AND veterinarian = :veterinarian AND date=:date');
        $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
        $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
        $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->execute()){
            if($stmt->fetch() == null) return false;
        else return true;
        }
    }
    catch(error $e){
        return true;
    }
}

function commentExistbyId($id){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto 
        WHERE id_comment = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->execute()){
            if($stmt->fetch() == null) return false;
        else return true;
        }
    }
    catch(error $e){
        return true;
    }
}

/**
 * Summary of changeStatusCommentRequest : permet d'archiver ou rendre actif un commentaire
 * @param int $id : identifiant du commentaire
 * @param bool $status : 1 pour archivé, 0 pour actif
 * @return string : success ou error
 */
function changeStatusCommentRequest(int $id,bool $status){
    try{
        //on vérifie que le service existe et qu'il y a une modification à faire
        if(commentExistById($id)){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('UPDATE comments_housing_veto SET archive = :status WHERE id_comment = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":status", $status, PDO::PARAM_BOOL);
            $stmt->execute();
        }
        return "success";
    }
    catch(error $e){
        echo('erreur bd');
        return "error";
    }
}

function addCommentRequest($veto, $date, $housing, $comment){
    try{
        if(commentExist($veto, $date, $housing, $comment)==false){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('insert into comments_housing_veto (veterinarian,housing,comment,date) 
            VALUES (:veterinarian,:housing,:comment,:date)');
            $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
            $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
            $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
            $stmt->bindParam(":date", $date, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    catch(error $e)
    {

    }
}

function deleteCommentRequest(int $id){
    try{
        if(commentExistById($id)==true){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('DELETE FROM comments_housing_veto WHERE id_comment = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    catch(error $e)
    {

    }
}