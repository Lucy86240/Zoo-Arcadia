<?php
include_once "Model/FedAnimal.php";

/**
 * Summary of FedAnimalWithFilter
 * @param int $id : id de l'animal
 * @param mixed $dateStart : la date la plus ancienne des rapports souhaitées (peut être null)
 * @param mixed $dateEnd : la date la plus récente des rapports souhaitées (peut être null)
 * @param mixed $limit : le nombre de retour souhaité (peut être null)
 * @return array
 */
function foodWithFilter(int $id,$dateStart,$dateEnd, $limit){
    try{
        if($dateStart != '') $dateStartRequest = ' AND date >= \''.$dateStart.'\'';
        else $dateStartRequest = '';

        if($dateEnd != '') $dateEndRequest =' AND date <= \''.$dateEnd.'\'';
        else $dateEndRequest = '';

        if($limit != '') $limitRequest = ' LIMIT '.$limit;
        else $limitRequest = '';

        $request = 'SELECT * FROM fed_animals WHERE animal = '.$id.$dateStartRequest.$dateEndRequest.' ORDER BY date DESC'.$limitRequest;

        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, 'FedAnimal');
        return $res;
    }
    catch(error $e){
        return [];
    }
}

function foodExist(int $id,$employee,$date,$hour,$foodFed,$weightFed){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare('SELECT * FROM fed_animals 
            WHERE animal = :id AND employee = :employee AND date=:date AND hour=:hour AND food=:food AND weight=:weight');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":employee", $employee, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":hour", $hour, PDO::PARAM_STR);
        $stmt->bindParam(":food", $foodFed, PDO::PARAM_STR);
        $stmt->bindParam(":weight", $weightFed, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'FedAnimal');
        if($stmt->execute()){
            if($stmt->fetch() == null) return false;
            else return true;
        }
    }
    catch(error $e){
        return true;
    }
}

function addFedAnimalRequest(int $id_animal,$employee, $date, $hour, $foodFed,$weightFoodFed){
        //vérifie que la race n'existe pas
        try{
            if(foodExist($id_animal,$employee,$date,$hour,$foodFed,$weightFoodFed)==false){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('insert into fed_animals (animal,employee,date,hour,food,weight) 
                    VALUES (:animal,:employee,:date,:hour,:food,:weight)');
                $stmt->bindParam(":animal", $id_animal, PDO::PARAM_INT);
                $stmt->bindParam(":employee", $employee, PDO::PARAM_STR);
                $stmt->bindParam(":date", $date, PDO::PARAM_STR);
                $stmt->bindParam(":hour", $hour, PDO::PARAM_STR);
                $stmt->bindParam(":food", $foodFed, PDO::PARAM_STR);
                $stmt->bindParam(":weight", $weightFoodFed, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
        catch(error $e)
        {

        }
}

/**
 * Summary of allFoodRequest : retourne tous les rapports médicaux avec possibilité de filtres
 * @param mixed $breeds : tableau de race en cas de filtre (null sinon)
 * @param mixed $animals : tableau d'animaux en cas de filtre (null sinon)
 * @param mixed $employeee : tableau de vétérinaire en cas de filtre (null sinon)
 * @param mixed $dateStart : date du rapport le plus ancien en cas de filtre (null sinon)
 * @param mixed $dateEnd : date du rapport le plus récent en cas de filtre (null sinon)
 * @param mixed $firt : numéro du premier rapport à transmettre (en cas de pagination)
 * @param mixed $nbFood : nombre de rapports max à retourner
 * @return array
 */
function allFoodRequest($breeds,$animals,$employee,$dateStart,$dateEnd, $first, $nbFood){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        
        //gestion de la pagination
        $offset = '';
        if($first != null) $offset=' OFFSET '.$first;

        // pas de filtre
        if($breeds==null && $animals==null && $employee==null && $dateStart==null && $dateEnd==null){
            $stmt = $pdo->prepare('SELECT * FROM fed_animals ORDER BY date DESC LIMIT :limit'.$offset);
            $stmt->bindParam(":limit", $nbFood, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS,'FedAnimal');
            if($stmt->execute()){
                return $stmt->fetchAll();
            }
            else return [];
        }
        else{
            $request="WHERE";
            //filtre employee
            if($employee!=null){
                $request.=" (employee=\"".$employee[0]."\"";
                for($i=1;$i<count($employee);$i++){
                    $request .= " OR employee=\"".$employee[$i]."\"";
                }
                $request.=')';
            }
            //filter date de début
            if($dateStart != null){
                if($request!='WHERE') $request.=" AND";
                $request .= " date >= \"".$dateStart."\"";
            }
            //filtre date de fin
            if($dateEnd != null){
                if($request!='WHERE') $request.=" AND";
                $request .= " date <= \"".$dateEnd."\"";
            }

            //filtre race qui nécessite une jonction
            if($breeds!=null){
                if($request != "WHERE") $request.=" AND";
                $request.=" (animals.breed=".$breeds[0];
                for($i=1;$i<count($breeds);$i++){
                    $request.=" OR animals.breed=".$breeds[$i];
                }
                $request .= ')';
                $stmt = $pdo->prepare('SELECT fed_animals.* FROM fed_animals JOIN animals ON fed_animals.animal = animals.id_animal '.$request.' ORDER BY date DESC LIMIT :limit'.$offset);
                $stmt->bindParam(":limit", $nbFood, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,'FedAnimal');
                if($stmt->execute()){
                    return $stmt->fetchAll();
                }
                else return [];
            }
            else{
                $stmt = $pdo->prepare('SELECT * FROM fed_animals '.$request.' ORDER BY date DESC LIMIT :limit'.$offset);
                $stmt->bindParam(":limit", $nbFood, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,'FedAnimal');
                if($stmt->execute()){
                    return $stmt->fetchAll();
                }
                else return [];
            }
        }
    }
    catch(error $e){
        return [];
    }
}

function countFoodFilter($breeds,$animals,$employee,$dateStart,$dateEnd){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        if($breeds==null && $animals==null && $employee==null && $dateStart==null && $dateEnd==null){
            $stmt = $pdo->prepare('SELECT count(*) FROM fed_animals');
            if($stmt->execute()){
                $res=$stmt->fetch();
                return $res[0];
            }
            else return 0;
        }
        else{
            $request="WHERE";
            if($employee!=null){
                $request.=" (employee=\"".$employee[0]."\"";
                for($i=1;$i<count($employee);$i++){
                    $request .= " OR employee=\"".$employee[$i]."\"";
                }
                $request.=')';
            }
            if($dateStart != null){
                if($request!='WHERE') $request.=" AND";
                $request .= " date >= \"".$dateStart."\"";
            }
            if($dateEnd != null){
                if($request!='WHERE') $request.=" AND";
                $request .= " date <= \"".$dateEnd."\"";
            }
            if($breeds!=null){
                if($request != "WHERE") $request.=" AND";
                $request.=" (animals.breed=".$breeds[0];
                for($i=1;$i<count($breeds);$i++){
                    $request.=" OR animals.breed=".$breeds[$i];
                }
                $request .= ')';
                $stmt = $pdo->prepare('SELECT count(*) FROM fed_animals JOIN animals ON fed_animals.animal = animals.id_animal '.$request);
                if($stmt->execute()){
                    $res=$stmt->fetch();
                    return $res[0];
                }
                else return 0;
            }
            else{
                $stmt = $pdo->prepare('SELECT count(*) FROM fed_animals '.$request);
                if($stmt->execute()){
                    $res=$stmt->fetch();
                    return $res[0];
                }
                else return 0;

            }
        }
    }
    catch(error $e){
        return 0;
    }
}

