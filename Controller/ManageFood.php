<?php
if($_SERVER['REQUEST_URI']!='/Controller/ManageFood.php'){
    include_once "Controller/ManageAnimal.php";
    include_once "Model/ManageFedAnimalModel.php";

    function addFood($animal, &$foods, $perPage, $first){
        if(isset($_POST['addFood']) && $_POST['addFood']!=null){
            $problem = false;
            if(isset($_POST['dateFed']) && isDate($_POST['dateFed'])){
                $date=$_POST['dateFed'];
            }
            else{
                $problem = true;
            }
            if(isset($_POST['hourFed'])){
                $hour=$_POST['hourFed'];
            }
            else{
                $problem = true;
            }
            if(isset($_POST['searchAnimalFed']) && is_numeric($_POST['searchAnimalFed'])){
                $id_animal = $_POST['searchAnimalFed'];
            }
            else{
                if($animal != null && animalExistById($animal['id'])) $id_animal =$animal['id'];
                else $problem = true;
                $msg='Le repas n\'a pas été enregistré car vous devez sélectionner un animal';
            }
            if(isset($_POST['foodFed']) && isText($_POST['foodFed'])){
                $foodFed = $_POST['foodFed'];
            }
            else{
                $problem = true;
            }
            if(isset($_POST['weightFed']) && isText($_POST['weightFed'])){
                $weightFed = $_POST['weightFed'];
            }
            else{
                $problem = true;
            }
            if(!$problem){
                addFedAnimalRequest($id_animal, $_SESSION['mail'],$date,$hour,$foodFed,$weightFed);
                $_POST['addFood']=null;
            }
            if($foods != null) filter($foods,$nbFoods,$perPage,$first);
        }
    }

    function changeFoodObjectToAssociatif(FedAnimal $foodObject){
        return array(
            "employee" => $foodObject->getEmployee(),
            "animal" => animalById($foodObject->getIdAnimal(),false,false),
            "date" => date("d/m/Y",strtotime($foodObject->getDate())),
            "hour" => $foodObject->getHour(),
            "food" => $foodObject->getFood(),
            "weight" => $foodObject->getWeight(),
        );

    }
    function allFoods($breeds,$animals,$employee,$dateStart,$dateEnd, $first, $nbFoods){
        $FoodsObject=allFoodRequest($breeds,$animals,$employee,$dateStart,$dateEnd, $first, $nbFoods);
        $Foods=[];
        foreach($FoodsObject as $FoodObject){
            $Food = changeFoodObjectToAssociatif($FoodObject);
            array_push($Foods,$Food);
        }
        return $Foods;
    }

    function filter(&$Foods, &$nbFoods, $perPage, $first){
        if(isset($_POST['choices'])){
            //filtre des races
            $breeds=[];
            $_SESSION['allFedAnimals_filterBreeds']=[];
            $lenght = count(listAllBreeds());
            for($i=0;$i<$lenght;$i++){
                if(isset($_POST['breedSelected'.$i])){
                    array_push($breeds,$_POST['breedSelected'.$i]);
                    array_push($_SESSION['allFedAnimals_filterBreeds'],$_POST['breedSelected'.$i]);
                }
            }
            if($breeds==[]) $breeds=null;

            //filtre des employé
            $lenght = count(listOfUserByRole(3));
            $all=true;
            $employees = [];
            for($i=0;$i<$lenght;$i++){
                if(isset($_POST['employee'.$i])){
                    array_push($employees,$_POST['employee'.$i]);
                }
                else $all=false;
            }
            $_SESSION['allFedAnimals_filteremployee']=$employees;
            if($all==true) $employees = null;

            if(isset($_POST['dateStart']) && $_POST['dateStart']!=''){
                $dateStart=$_POST['dateStart'];
            } 
            else $dateStart=null;
            $_SESSION['allFedAnimals_filterdateStart']=$dateStart;

            if(isset($_POST['dateEnd']) && $_POST['dateEnd']!=''){
                $dateEnd=$_POST['dateEnd'];
            } 
            else $dateEnd=null;
            $_SESSION['allFedAnimals_filterdateEnd']=$dateEnd;

            $Foods=allFoods($breeds,null,$employees,$dateStart,$dateEnd,null,$perPage);
            $nbFoods=countFoodFilter($breeds,null,$employees,$dateStart,$dateEnd);

        }
        else{
            $breeds = null;
            if(isset($_SESSION['allFedAnimals_filterBreeds'])) $breeds=$_SESSION['allFedAnimals_filterBreeds'];
            
            $employees=null;
            if(isset($_SESSION['allFedAnimals_filteremployee'])) $employees=$_SESSION['allFedAnimals_filteremployee'];
            
            $dateStart=null;
            if(isset($_SESSION['allFedAnimals_filterdateStart'])) $dateStart=$_SESSION['allFedAnimals_filterdateStart'];
            
            $dateEnd=null;
            if(isset($_SESSION['allFedAnimals_filterdateEnd'])) $dateEnd=$_SESSION['allFedAnimals_filterdateEnd'];

            $Foods = allFoods($breeds,null,$employees,$dateStart,$dateEnd,$first,$perPage);
            $nbFoods=countFoodFilter($breeds,null,$employees,$dateStart,$dateEnd);
            
        }
        if(isset($_POST['cancelFilter'])){
            $_SESSION['allFedAnimals_filterBreeds']=null;
            $_SESSION['allFedAnimals_filterdateEnd']=null;
            $_SESSION['allFedAnimals_filterdateStart']=null;
            $_SESSION['allFedAnimals_filteremployee']=null;
            $Foods = allFoods(null,null,null,null,null,$first,$perPage);
            $nbFoods=countFoodFilter(null,null,null,null,null);
        }
    }

    function urlOption($page,$optionPage){
        $url="";
        if(!$optionPage) $url.="repas/";
        $url.="?page=".$page;
        echo($url);
    }


    function defaultValueCheckbox(string $filter, $value){
        if(isset($_POST[$filter])) return 'checked';
        else{
            if(!isset($_POST['choices'])){
                if(substr($filter,0,4)=="employee"){
                    
                    if(isset($_SESSION['allFedAnimals_filteremployee'])){
                        $ind = array_search($value,$_SESSION['allFedAnimals_filteremployee'],true);
                        if($_SESSION['allFedAnimals_filteremployee'][$ind] == $value) return 'checked';
                        else return '';
                    } 
                    else return 'checked';
                }
                elseif(substr($filter,0,13)=="breedSelected"){
                    if(isset($_SESSION['allFedAnimals_filterBreeds'])){
                        $ind = array_search($value,$_SESSION['allFedAnimals_filterBreeds'],true);
                        if(isset($_SESSION['allFedAnimals_filterBreeds'][$ind]) && $_SESSION['allFedAnimals_filterBreeds'][$ind]==$value) return 'checked';
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
            if(!isset($_POST['choices']) && isset($_SESSION['allFedAnimals_filter'.$filter])) return $_SESSION['allFedAnimals_filter'.$filter];
            else return '';
        }
        
    }

    function displayFoods($currentPage,$perPage,&$Foods,&$pages,&$nbFoods,&$first){
        //on détermine le 1er avis à afficher
        $first = ($currentPage * $perPage) - $perPage;
        
        //on récupère les infos de la base de données
        $Foods=allFoods(null,null,null,null,null,null,$perPage);
        filter($Foods,$nbFoods,$perPage,$first);

        // On calcule le nombre de pages totales
        $pages = ceil($nbFoods / $perPage);
        
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
    $foods=null;
    $pages=null;
    $nbFoods=0;
    $perPage=20;
    $first=null;

    displayFoods($currentPage,$perPage,$foods,$pages,$nbFoods,$first);

    addFood(null,$foods,$perPage,$first);
    $employees = listOfUserByRole(3);
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
        
