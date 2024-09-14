<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/ManageMedicalReports.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once "Controller/ManageAnimal.php";
        require_once "Model/ManageMedicalReportsModel.php";
    
        /**
         * Summary of addReport : ajout d'un rapport médical dans la base de données (nécessite un formulaire)
         * @param mixed $animal : tableau asso de l'animal concerné (null si inclus dans le formulaire)
         * @param mixed $reports : tableau asso des rapports à mettre à jour (null si pas besoin)
         * @param mixed $perPage : nombre de rapport par page (pour pagination)
         * @param mixed $first : position du 1er rapport du tableau (pour pagination)
         * @return string
         */
        function addReport($animal, &$reports, $perPage, $first){
            //si on clique sur ajouter
            if(isset($_POST['addReport']) && $_POST['addReport']!=null){
                $problem = false;
                //on récupère la date du rapport si elle est bien renseignée
                if(isset($_POST['dateNewReport']) && isDate($_POST['dateNewReport'])){
                    $date=$_POST['dateNewReport'];
                }
                else{
                    $problem = true;
                    $msg = "Désolé, le rapport n'a pas pu être enregistré... <br> La date est erronée.";
                }
                //on récupère l'id de l'animal du rapport s'il est bien renseigné
                if(isset($_POST['searchAnimalNewReport']) && is_numeric($_POST['searchAnimalNewReport'])){
                    $id_animal = $_POST['searchAnimalNewReport'];
                }
                else{
                    //sinon on prend celui des paramètres de la fonction
                    if($animal != null && animalExistById($animal['id'])) $id_animal =$animal['id'];
                    else{
                        $problem = true;
                        $msg='Le rapport n\'a pas été enregistré car vous devez sélectionner un animal';
                    } 
                }
    
                //on récupère la santé
                if(isset($_POST['healthNewReport']) && isText($_POST['healthNewReport'])){
                    $healthNewReport = $_POST['healthNewReport'];
                }
                else{
                    $problem=true;
                    $msg = "Désolé, le rapport n'a pas pu être enregistré... <br> Il y a un souci avec la santé.";
                }
    
                //on récupère le détail de la santé
                if(isset($_POST['commentNewReport']) && isText($_POST['commentNewReport'])){
                    $commentNewReport = $_POST['commentNewReport'];
                }
                else{
                    $commentNewReport = null;
                }
    
                //on récupère la nourriture proposée
                if(isset($_POST['foodNewReport']) && isText($_POST['foodNewReport'])){
                    $foodNewReport = $_POST['foodNewReport'];
                }
                else{
                    $problem = true;
                    $msg = "Désolé, le rapport n'a pas pu être enregistré... <br> Il y a un souci avec la nourriture.";
                }
    
                //on récupère la quantité proposée
                if(isset($_POST['weightFoodNewReport']) && isText($_POST['weightFoodNewReport'])){
                    $weightFoodNewReport = $_POST['weightFoodNewReport'];
                }
                else{
                    $problem = true;
                    $msg = "Désolé, le rapport n'a pas pu être enregistré... <br> Il y a un souci avec le grammage.";
                    
                }
    
                //si on a tout récupéré on l'ajoute à la base de données
                if(!$problem){
                    addMedicalReportRequest($id_animal, $_SESSION['mail'],$date, $healthNewReport,$commentNewReport,$foodNewReport,$weightFoodNewReport);
                    $_POST['addReport']=null;
                }
                //on met à jour le tableau des rapports
                if($reports != null) filter($reports,$nbReports,$perPage,$first);
                if($problem) return $msg;
                else return "Success";
            }
            return null;

        }
    
        /**
         * Summary of changeReportObjectToAssociatif : converti un objet MidicalReport en tableau associatif
         * @param MedicalReport $reportObject : objet rapport médical à convertir
         * @return array : tableau associatif (veterinarian,animal,date,health,comment,food,weight_of_food)
         */
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
    
        /**
         * Summary of allReports : retourne des rapports médicaux en fonction de filtres
         * @param mixed $breeds : tableau d'id de race ou null
         * @param mixed $animals : tableau d'id d'animaux ou null
         * @param mixed $veto : tableau d'id de vétérinaire ou null
         * @param mixed $dateStart : date de début ou null
         * @param mixed $dateEnd : date de fin ou null
         * @param mixed $first : position du 1er rapport du tableau (pour pagination)
         * @param mixed $nbReports : nombre de rapports dans le tableau (pour pagination)
         * @return array : tableau associatifs de rapports médicaux
         */
        function allReports($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports){
            //on récupère les objets de rapports en fonction des filtres
            $reportsObject=allReportsRequest($breeds,$animals,$veto,$dateStart,$dateEnd, $first, $nbReports);
            //on le converti en tableau associatif
            $reports=[];
            foreach($reportsObject as $reportObject){
                $report = changeReportObjectToAssociatif($reportObject);
                array_push($reports,$report);
            }
            return $reports;
        }
    
        /**
         * Summary of filter met à jour le tableau de rapports et nombre total des rapports en fonction des filtres $_POST $_SESSION
         * @param mixed $reports : tableau des rapports à mettre à jour
         * @param mixed $nbReports : nombre de rapports total suivant les filtres mis à jour
         * @param mixed $perPage : nombre de rapport par page (pour pagination)
         * @param mixed $first : position du 1er rapport du tableau (pour pagination)
         * @return void
         */
        function filter(&$reports, &$nbReports, $perPage, $first){
            //si on vient de valider un filtre
            if(isset($_POST['choices'])){
                //filtre des races
                $breeds=[];
                $_SESSION['allMedicalReports_filterBreeds']=[];
                $lenght = count(listAllBreeds());
                for($i=0;$i<$lenght;$i++){
                    //on met dans le tableaux des races celle sélectionnées
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
    
                //filtre date de début
                if(isset($_POST['dateStart']) && $_POST['dateStart']!='' && isDate($_POST['dateStart'])){
                    $dateStart=$_POST['dateStart'];
                } 
                else $dateStart=null;
                $_SESSION['allMedicalReports_filterdateStart']=$dateStart;
    
                //filtre date de fin
                if(isset($_POST['dateEnd']) && $_POST['dateEnd']!='' && isDate($_POST['dateEnd'])){
                    $dateEnd=$_POST['dateEnd'];
                } 
                else $dateEnd=null;
                $_SESSION['allMedicalReports_filterdateEnd']=$dateEnd;
    
                //on met à jour les variables entrées en paramètres
                $reports=allReports($breeds,null,$veterinarians,$dateStart,$dateEnd,null,$perPage);
                $nbReports=countReportsFilter($breeds,null,$veterinarians,$dateStart,$dateEnd);
    
            }
            else{
                //on regarde si un filtre avait été validé sur une page antérieure
                $breeds = null;
                if(isset($_SESSION['allMedicalReports_filterBreeds'])) $breeds=$_SESSION['allMedicalReports_filterBreeds'];
                
                $veterinarians=null;
                if(isset($_SESSION['allMedicalReports_filterVeto'])) $veterinarians=$_SESSION['allMedicalReports_filterVeto'];
                
                $dateStart=null;
                if(isset($_SESSION['allMedicalReports_filterdateStart'])) $dateStart=$_SESSION['allMedicalReports_filterdateStart'];
                
                $dateEnd=null;
                if(isset($_SESSION['allMedicalReports_filterdateEnd'])) $dateEnd=$_SESSION['allMedicalReports_filterdateEnd'];
    
                //on met à jour les variables entrées en paramètre
                $reports = allReports($breeds,null,$veterinarians,$dateStart,$dateEnd,$first,$perPage);
                $nbReports=countReportsFilter($breeds,null,$veterinarians,$dateStart,$dateEnd);
                
            }
            //si on annule les filtres
            if(isset($_POST['cancelFilter'])){
                //on réinitialise tout
                $_SESSION['allMedicalReports_filterBreeds']=null;
                $_SESSION['allMedicalReports_filterdateEnd']=null;
                $_SESSION['allMedicalReports_filterdateStart']=null;
                $_SESSION['allMedicalReports_filterVeto']=null;
    
                //on met à jour les variables entrées en paramètre
                $reports = allReports(null,null,null,null,null,1,$perPage);
                $nbReports=countReportsFilter(null,null,null,null,null);
            }
        }
    
        /**
         * Summary of urlOption : affiche l'url voulu
         * @param mixed $page : page sur laquelle on veut aller
         * @param mixed $optionPage : si des paramètres existent sur la page actuelle
         * @return void
         */
        function urlOption($page,$optionPage){
            $url="";
            if(!$optionPage) $url.="rapports_medicaux/";
            $url.="?page=".$page;
            echo($url);
        }
    
        /**
         * Summary of defaultValueCheckbox : indique checked si la case doit être cochée sinon rien
         * @param string $filter : nom de la checkbox
         * @param mixed $value : valeur qu'a la checkbox
         * @return string : '' ou 'checked'
         */
        function defaultValueCheckbox(string $filter, $value){
            if(isset($_POST[$filter])) return 'checked';
            else{
                if(!isset($_POST['choices'])){
                    if(substr($filter,0,4)=="veto"){
                        
                        if(isset($_SESSION['allMedicalReports_filterVeto'])){
                            $ind = array_search($value,$_SESSION['allMedicalReports_filterVeto'],true);
                            if(isset($_SESSION['allMedicalReports_filterVeto'][$ind]) && $_SESSION['allMedicalReports_filterVeto'][$ind] == $value) return 'checked';
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
                    else{
                        return '';
                    }
                }
                else return '';
            }
        }
    
            /**
         * Summary of defaultValueDate : indique la date par défaut du input date
         * @param string $filter : name du input date
         * @return mixed : '' ou la date voulue
         */
        function defaultValueDate(string $filter){
            if(isset($_POST[$filter])) return $_POST[$filter];
            else{
                if(!isset($_POST['choices']) && isset($_SESSION['allMedicalReports_filter'.$filter])) return $_SESSION['allMedicalReports_filter'.$filter];
                else return '';
            }
            
        }
    
        /**
         * Summary of displayReports permet de récupérer les variables : reports,pages,nbreports,first
         * @param mixed $currentPage : page actuelle
         * @param mixed $perPage : nombre de rapport par page
         * @param mixed $reports : tableau de rapports à mettre à jour
         * @param mixed $pages : nombre de pages totales
         * @param mixed $nbReports : nombre de rapports totaux
         * @param mixed $first : position du 1er rapport du tableau
         * @return void
         */
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
    
        //on permet d'ajouter un rapport
        $msg = null;
        $msg = addReport(null,$reports,$perPage,$first);
        //on initialise la liste des vétérinaires
        $veterinarians = listOfUserByRole(2);
}
        
