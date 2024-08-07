<?php

include_once "Controller/ManageAnimal.php";
include_once "Model/ManageMedicalReportsModel.php";

function addReport($animal, &$reports,$breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports){
    if(isset($_POST['addReport']) && $_POST['addReport']!=null){
        $problem = false;
        if(isset($_POST['dateNewReport'])){
            $date=$_POST['dateNewReport'];
        }
        else{
            $problem = true;
        }
        if(isset($_POST['searchAnimalNewReport'])){
            $id_animal = $_POST['searchAnimalNewReport'];
        }
        else{
            if($animal != null && animalExistById($animal['id'])) $id_animal =$animal['id'];
            else $problem = true;
            $msg='La rapport n\'a pas été enregistré car vous devez sélectionner un animal';
        }
        if(isset($_POST['healthNewReport'])){
            $healthNewReport = $_POST['healthNewReport'];
        }
        else{
            $problem=true;
        }
        if(isset($_POST['commentNewReport'])){
            $commentNewReport = $_POST['commentNewReport'];
        }
        else{
            $commentNewReport = null;
        }
        if(isset($_POST['foodNewReport'])){
            $foodNewReport = $_POST['foodNewReport'];
        }
        else{
            $problem = true;
        }
        if(isset($_POST['weightFoodNewReport'])){
            $weightFoodNewReport = $_POST['weightFoodNewReport'];
        }
        else{
            $problem = true;
        }
        if(!$problem){
            addMedicalReportRequest($id_animal, $_SESSION['mail'],$date, $healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport);
            $_POST['addReport']=null;
        }
        if($reports != null) $reports = allReports($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports);
    }
}

function changeReportObjectToAssociatif(MedicalReport $reportObject){
    return array(
        "veterinarian" => $reportObject->getVeterinarian(),
        "animal" => animalById($reportObject->getIdAnimal(),false),
        "date" => date("d/m/Y",strtotime($reportObject->getDate())),
        "health" => $reportObject->getHealth(),
        "comment" => $reportObject->getComment(),
        "food" => $reportObject->getFood(),
        "weight_of_food" => $reportObject->getWeightOfFood(),
    );

}
function allReports($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports){
    $reportsObject=allReportsRequest($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports);
    $reports=[];
    foreach($reportsObject as $reportObject){
        $report = changeReportObjectToAssociatif($reportObject);
        array_push($reports,$report);
    }
    return $reports;
}

function filter(&$reports){
    if(isset($_POST['choices'])){

        //filtre des races
        $breeds=[];
        $lenght = count(listAllBreeds());
        for($i=0;$i<$lenght;$i++){
            if(isset($_POST['breedSelected'.$i])){
                array_push($breeds,$_POST['breedSelected'.$i]);
            }
        }
        if($breeds==[]) $breeds=null;

        //filtre des vétérinaires
        $lenght = count(listOfUserByRole(2));
        $all=true;
        $veterinarians = [];
        for($i=0;$i<$lenght;$i++){
            if(isset($_POST['veto'.$i])) array_push($veterinarians,$_POST['veto'.$i]);
            else $all=false;
        }
        if($all==true) $veterinarians = null;

        if(isset($_POST['dateStart']) && $_POST['dateStart']!='') $dateStart=$_POST['dateStart'];
        else $dateStart=null;

        if(isset($_POST['dateEnd']) && $_POST['dateEnd']!='') $dateEnd=$_POST['dateEnd'];
        else $dateEnd=null;

        $reports=allReports($breeds,null,$veterinarians,$dateStart,$dateEnd,null,30);
    }
}

function defaultValueCheckbox(string $filter){
    if(isset($_POST[$filter])) return 'checked';
    else{
        if(!isset($_POST['choices'])){
            if(substr($filter,0,4)=="veto") return 'checked';
            else return '';
        }
        else return '';
    }
}

function defaultValueDate(string $filter){
    if(isset($_POST[$filter])) return $_POST[$filter];
    else return '';
}

$reports=allReports(null,null,null,null,null,null,30);
addReport(null,$reports,null,null,null,null,null,null,30);
$veterinarians = listOfUserByRole(2);
filter($reports);
