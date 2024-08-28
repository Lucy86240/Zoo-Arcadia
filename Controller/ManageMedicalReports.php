<?php
if($_SERVER['REQUEST_URI']=='/Controller/ManageMedicalReports.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    include_once "Controller/ManageAnimal.php";
    include_once "Model/ManageMedicalReportsModel.php";

    function addReport($animal, &$reports, $perPage, $first){
        if(isset($_POST['addReport']) && $_POST['addReport']!=null){
            $problem = false;
            if(isset($_POST['dateNewReport']) && isDate($_POST['dateNewReport'])){
                $date=$_POST['dateNewReport'];
            }
            else{
                $problem = true;
            }
            if(isset($_POST['searchAnimalNewReport']) && is_numeric($_POST['searchAnimalNewReport'])){
                $id_animal = $_POST['searchAnimalNewReport'];
            }
            else{
                if($animal != null && animalExistById($animal['id'])) $id_animal =$animal['id'];
                else $problem = true;
                $msg='La rapport n\'a pas été enregistré car vous devez sélectionner un animal';
            }
            if(isset($_POST['healthNewReport']) && isText($_POST['healthNewReport'])){
                $healthNewReport = $_POST['healthNewReport'];
            }
            else{
                $problem=true;
            }
            if(isset($_POST['commentNewReport']) && isText($_POST['commentNewReport'])){
                $commentNewReport = $_POST['commentNewReport'];
            }
            else{
                $commentNewReport = null;
            }
            if(isset($_POST['foodNewReport']) && isText($_POST['foodNewReport'])){
                $foodNewReport = $_POST['foodNewReport'];
            }
            else{
                $problem = true;
            }
            if(isset($_POST['weightFoodNewReport']) && isText($_POST['weightFoodNewReport'])){
                $weightFoodNewReport = $_POST['weightFoodNewReport'];
            }
            else{
                $problem = true;
            }
            if(!$problem){
                addMedicalReportRequest($id_animal, $_SESSION['mail'],$date, $healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport);
                $_POST['addReport']=null;
            }
            if($reports != null) filter($reports,$nbReports,$perPage,$first);
        }
    }

    function changeReportObjectToAssociatif(MedicalReport $reportObject){
        return array(
            "veterinarian" => $reportObject->getVeterinarian(),
            "animal" => animalById($reportObject->getIdAnimal(),false,false),
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

    function filter(&$reports, &$nbReports, $perPage, $first){
        if(isset($_POST['choices'])){
            //filtre des races
            $breeds=[];
            $_SESSION['allMedicalReports_filterBreeds']=[];
            $lenght = count(listAllBreeds());
            for($i=0;$i<$lenght;$i++){
                if(isset($_POST['breedSelected'.$i])){
                    array_push($breeds,$_POST['breedSelected'.$i]);
                    array_push($_SESSION['allMedicalReports_filterBreeds'],$_POST['breedSelected'.$i]);
                }
            }
            if($breeds==[]) $breeds=null;

            //filtre des vétérinaires
            $lenght = count(listOfUserByRole(2));
            $all=true;
            $veterinarians = [];
            for($i=0;$i<$lenght;$i++){
                if(isset($_POST['veto'.$i])){
                    array_push($veterinarians,$_POST['veto'.$i]);
                }
                else $all=false;
            }
            $_SESSION['allMedicalReports_filterVeto']=$veterinarians;
            if($all==true) $veterinarians = null;

            if(isset($_POST['dateStart']) && $_POST['dateStart']!='' && isDate($_POST['dateStart'])){
                $dateStart=$_POST['dateStart'];
            } 
            else $dateStart=null;
            $_SESSION['allMedicalReports_filterdateStart']=$dateStart;

            if(isset($_POST['dateEnd']) && $_POST['dateEnd']!='' && isDate($_POST['dateEnd'])){
                $dateEnd=$_POST['dateEnd'];
            } 
            else $dateEnd=null;
            $_SESSION['allMedicalReports_filterdateEnd']=$dateEnd;

            $reports=allReports($breeds,null,$veterinarians,$dateStart,$dateEnd,null,$perPage);
            $nbReports=countReportsFilter($breeds,null,$veterinarians,$dateStart,$dateEnd);

        }
        else{
            $breeds = null;
            if(isset($_SESSION['allMedicalReports_filterBreeds'])) $breeds=$_SESSION['allMedicalReports_filterBreeds'];
            
            $veterinarians=null;
            if(isset($_SESSION['allMedicalReports_filterVeto'])) $veterinarians=$_SESSION['allMedicalReports_filterVeto'];
            
            $dateStart=null;
            if(isset($_SESSION['allMedicalReports_filterdateStart'])) $dateStart=$_SESSION['allMedicalReports_filterdateStart'];
            
            $dateEnd=null;
            if(isset($_SESSION['allMedicalReports_filterdateEnd'])) $dateEnd=$_SESSION['allMedicalReports_filterdateEnd'];

            $reports = allReports($breeds,null,$veterinarians,$dateStart,$dateEnd,$first,$perPage);
            $nbReports=countReportsFilter($breeds,null,$veterinarians,$dateStart,$dateEnd);
            
        }
        if(isset($_POST['cancelFilter'])){
            $_SESSION['allMedicalReports_filterBreeds']=null;
            $_SESSION['allMedicalReports_filterdateEnd']=null;
            $_SESSION['allMedicalReports_filterdateStart']=null;
            $_SESSION['allMedicalReports_filterVeto']=null;
            $reports = allReports(null,null,null,null,null,$first,$perPage);
            $nbReports=countReportsFilter(null,null,null,null,null);
        }
    }

    function urlOption($page,$optionPage){
        $url="";
        if(!$optionPage) $url.="rapports_medicaux/";
        $url.="?page=".$page;
        echo($url);
    }


    function defaultValueCheckbox(string $filter, $value){
        if(isset($_POST[$filter])) return 'checked';
        else{
            if(!isset($_POST['choices'])){
                if(substr($filter,0,4)=="veto"){
                    
                    if(isset($_SESSION['allMedicalReports_filterVeto'])){
                        $ind = array_search($value,$_SESSION['allMedicalReports_filterVeto'],true);
                        if($_SESSION['allMedicalReports_filterVeto'][$ind] == $value) return 'checked';
                        else return '';
                    } 
                    else return 'checked';
                }
                elseif(substr($filter,0,13)=="breedSelected"){
                    if(isset($_SESSION['allMedicalReports_filterBreeds'])){
                        $ind = array_search($value,$_SESSION['allMedicalReports_filterBreeds'],true);
                        if(isset($_SESSION['allMedicalReports_filterBreeds'][$ind]) && $_SESSION['allMedicalReports_filterBreeds'][$ind]==$value) return 'checked';
                        else return '';
                    } 
                    else return '';
                }
            }
            else return '';
        }
    }

    function defaultValueDate(string $filter){
        if(isset($_POST[$filter])) return $_POST[$filter];
        else{
            if(!isset($_POST['choices']) && isset($_SESSION['allMedicalReports_filter'.$filter])) return $_SESSION['allMedicalReports_filter'.$filter];
            else return '';
        }
        
    }

    function displayReports($currentPage,$perPage,&$reports,&$pages,&$nbReports,&$first){
        //on détermine le 1er avis à afficher
        $first = ($currentPage * $perPage) - $perPage;
        
        //on récupère les infos de la base de données
        $reports=allReports(null,null,null,null,null,null,$perPage);
        filter($reports,$nbReports,$perPage,$first);

        // On calcule le nombre de pages totales
        $pages = ceil($nbReports / $perPage);
        
    //fin de la fonction
    }

    //on indique si l'url a des paramètres
    if(!isset($_GET['page'])){
        $optionPage = false;
    }
    else{
        $optionPage = true;
    }

    // On détermine sur quelle page on se trouve
    if((isset($_GET['page']) && !empty($_GET['page']))&& !isset($_POST['choices'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    //on récupère les infos clés pour l'affichage des rapports
    $reports=null;
    $pages=null;
    $nbReports=0;
    $perPage=20;
    $first=null;

    displayReports($currentPage,$perPage,$reports,$pages,$nbReports,$first);

    addReport(null,$reports,$perPage,$first);
    $veterinarians = listOfUserByRole(2);
}
        
