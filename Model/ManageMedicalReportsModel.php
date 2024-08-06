<?php
include_once 'Model/MedicalReport.php';
/**
 * Summary of medicalReportWithFilter
 * @param int $id : id de l'animal
 * @param mixed $dateStart : la date la plus ancienne des rapports souhaitées (peut être null)
 * @param mixed $dateEnd : la date la plus récente des rapports souhaitées (peut être null)
 * @param mixed $limit : le nombre de retour souhaité (peut être null)
 * @return array
 */
function medicalReportWithFilter(int $id,$dateStart,$dateEnd, $limit){
    try{
        if($dateStart != '') $dateStartRequest = ' AND date >= \''.$dateStart.'\'';
        else $dateStartRequest = '';

        if($dateEnd != '') $dateEndRequest =' AND date <= \''.$dateEnd.'\'';
        else $dateEndRequest = '';

        if($limit != '') $limitRequest = ' LIMIT '.$limit;
        else $limitRequest = '';

        $request = 'SELECT * FROM reports_veterinarian WHERE animal = '.$id.$dateStartRequest.$dateEndRequest.' ORDER BY date DESC'.$limitRequest;

        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        $stmt = $pdo->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch(error $e){
        return [];
    }
}

function reportExist($id,$veto,$date,$healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        if($commentNewReport == null){
            $stmt = $pdo->prepare('SELECT * FROM reports_veterinarian 
            WHERE animal = :id AND veterinarian = :veterinarian AND date=:date AND health=:health AND food=:food AND weight_of_food=:weight_of_food');
        }
        else{
            $stmt = $pdo->prepare('SELECT * FROM reports_veterinarian 
            WHERE comment = :comment AND animal = :id AND veterinarian = :veterinarian AND date=:date AND health=:health AND food=:food AND weight_of_food=:weight_of_food');
            $stmt->bindParam(":comment", $commentNewReport, PDO::PARAM_STR);
        }
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":health", $healthNewReport, PDO::PARAM_STR);
        $stmt->bindParam(":food", $foodNewReport, PDO::PARAM_STR);
        $stmt->bindParam(":weight_of_food", $weightFoodNewReport, PDO::PARAM_STR);
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

function addMedicalReportRequest($id_animal,$veto, $date,$healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport){
        //vérifie que la race n'existe pas
        try{
            if(reportExist($id_animal,$veto,$date,$healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport)==false){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                if($commentNewReport!=null){
                    $stmt = $pdo->prepare('insert into reports_veterinarian (comment,animal,veterinarian,date,health,food,weight_of_food) 
                    VALUES (:comment,:animal,:veterinarian,:date,:health,:food,:weight_of_food)');
                    $stmt->bindParam(":comment", $commentNewReport, PDO::PARAM_STR);
                }
                else{
                    $stmt = $pdo->prepare('insert into reports_veterinarian (animal,veterinarian,date,health,food,weight_of_food) 
                    VALUES (:animal,:veterinarian,:date,:health,:food,:weight_of_food)');
                }
                $stmt->bindParam(":animal", $id_animal, PDO::PARAM_INT);
                $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
                $stmt->bindParam(":date", $date, PDO::PARAM_STR);
                $stmt->bindParam(":health", $healthNewReport, PDO::PARAM_STR);
                $stmt->bindParam(":food", $foodNewReport, PDO::PARAM_STR);
                $stmt->bindParam(":weight_of_food", $weightFoodNewReport, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
        catch(error $e)
        {

        }
}

/**
 * Summary of allReportsRequest : retourne tous les rapports médicaux avec possibilité de filtres
 * @param mixed $breeds : tableau de race en cas de filtre (null sinon)
 * @param mixed $animals : tableau d'animaux en cas de filtre (null sinon)
 * @param mixed $veto : tableau de vétérinaire en cas de filtre (null sinon)
 * @param mixed $dateStart : date du rapport le plus ancien en cas de filtre (null sinon)
 * @param mixed $dateEnd : date du rapport le plus récent en cas de filtre (null sinon)
 * @param mixed $firt : numéro du premier rapport à transmettre (en cas de pagination)
 * @param mixed $nbReports : nombre de rapports max à retourner
 * @return array
 */
function allReportsRequest($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports){
    try{
        $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
        if($breeds==null && $animals==null && $veto==null && $dateStart==null && $dateEnd==null && $first==null){
            $stmt = $pdo->prepare('SELECT * FROM reports_veterinarian ORDER BY date DESC LIMIT :limit');
            $stmt->bindParam(":limit", $nbReports, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS,'MedicalReport');
            if($stmt->execute()){
                return $stmt->fetchAll();
            }
            else return [];
        }
        else return [];
    }
    catch(error $e){
        return [];
    }
}