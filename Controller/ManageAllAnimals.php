<?php 

include_once "Controller/ManageAnimal.php";

function allAnimals($breeds, $housings, $isVisible, $sort, $first, $perPage, &$nbAnimals){
    $animals = [];
    $animalsObject = listAnimalsWithFilter($breeds, $housings, $isVisible, $sort, $first, $perPage, $nbAnimals);
    foreach($animalsObject as $animalObject){
        $animal['id'] = $animalObject->getId();
        $animal['name'] = $animalObject->getName();
        $animal['breed'] = $animalObject->getBreed();
        $animal['housing'] = $animalObject->getIdHousing();
        $animal['photo'] = $animalObject->getImage(0);
        if($animalObject->countImages()>0){
            $animal['photo']=[];
            $animal['photo']['path'] = $animalObject->getImage(0)->getPath();
            $animal['photo']['description'] = $animalObject->getImage(0)->getDescription();
        } else{
            $animal['photo']=[];
            $animal['photo']['path'] = IMG_DEFAULT_ANIMAL;
            $animal['photo']['description'] = "";
        }
        array_push($animals,$animal);
    }
    
    return $animals;
}

function defaultValueCheckbox(string $filter, $value){
    if(isset($_POST[$filter]) && $filter !='sort' && !isset($_POST['cancelFilter'])) return 'checked';
    elseif($filter=='sort'){
        if((!isset($_POST['sort']) || isset($_POST['cancelFilter'])) && $value=='popular') return 'checked';
        elseif(isset($_POST['sort']) && $_POST['sort']==$value && !isset($_POST['cancelFilter'])) return 'checked';
        elseif(isset ($_SESSION['allAnimals_sort']) && $_SESSION['allAnimals_sort']==$value) return 'checked';
        else return '';
    }
    else{
        if(!isset($_POST['choices'])){
            if(substr($filter,0,13)=="breedSelected"){
                if(isset($_SESSION['allAnimals_filterBreeds'])){
                    $ind = array_search($value,$_SESSION['allAnimals_filterBreeds'],false);
                    if(isset($_SESSION['allAnimals_filterBreeds'][$ind]) && $_SESSION['allAnimals_filterBreeds'][$ind]==$value) return 'checked';
                    else return '';
                } 
                else return '';
            }
            elseif(substr($filter,0,7)=="housing"){
                if(isset($_SESSION['allAnimals_filterhousings']) && $_SESSION['allAnimals_filterhousings']!=[]){
                    $ind = array_search($value,$_SESSION['allAnimals_filterhousings'],false);
                    if(isset($_SESSION['allAnimals_filterhousings'][$ind]) && $_SESSION['allAnimals_filterhousings'][$ind]==$value) return 'checked';
                    else return '';
                } 
                else return 'checked';
            }
            elseif($filter == 'archive'){
                if(isset($_SESSION['allAnimals_filterIsVisible']) && 
                ($_SESSION['allAnimals_filterIsVisible'] == 0 || $_SESSION['allAnimals_filterIsVisible']==2)) return 'checked';
                elseif(isset($_SESSION['allAnimals_filterIsVisible']) && ($_SESSION['allAnimals_filterIsVisible'] == 1)) return '';
                else return 'checked';
            }
            elseif($filter == 'visible'){
                if(isset($_SESSION['allAnimals_filterIsVisible']) && 
                ($_SESSION['allAnimals_filterIsVisible'] == 1 || $_SESSION['allAnimals_filterIsVisible']==2)) return 'checked';
                elseif(isset($_SESSION['allAnimals_filterIsVisible']) && ($_SESSION['allAnimals_filterIsVisible'] == 0)) return '';
                else return 'checked';
            }
        }
        else return '';
    }
}

function declareFilter(&$breeds, &$housings, &$isVisible, &$sort, &$first){
    if(isset($_POST['choices'])){
        
        // les races
        $_SESSION['allAnimals_filterBreeds']=[];
        $lenght=count(listAllBreeds());
        for($i=0; $i<$lenght;$i++){
            if(isset($_POST["breedSelected".$i])){
                array_push($_SESSION['allAnimals_filterBreeds'],$_POST["breedSelected".$i]);
            }
        }
        $breeds = $_SESSION['allAnimals_filterBreeds'];
        
        //les habitats
        $_SESSION['allAnimals_filterhousings']=[];
        $lenght=count(listNameIdAllHousings());
        for($i=0; $i<$lenght;$i++){
            if(isset($_POST["housing".$i])){
                array_push($_SESSION['allAnimals_filterhousings'],$_POST["housing".$i]);
            }
        }
        $housings = $_SESSION['allAnimals_filterhousings'];

        //statut
        if(isset($_POST["archive"]) && isset($_POST["visible"])) $isVisible = 2;
        else if(isset($_POST["archive"])) $isVisible = 0;
        else if(isset($_POST["visible"])) $isVisible = 1;
        else $isVisible = 2;
        $_SESSION['allAnimals_filterIsVisible']=$isVisible;

        if(isset($_POST['sort'])){
            $sort = $_POST['sort'];
            $_SESSION['allAnimals_sort'] = $sort;
        } 

        $first = 0;
    }
    if(isset($_POST['cancelFilter'])){
        $_SESSION['allAnimals_filterBreeds']=[];
        $_SESSION['allAnimals_filterhousings']=[];
        $_SESSION['allAnimals_filterIsVisible']=2;
        $_SESSION['allAnimals_sort'] = null;
    }
}

function urlOption($page, $optionPage){
    $url="";
    if(!$optionPage) $url.="animaux/";
    $url.="?page=".$page;
    echo($url);
}

//on indique si l'url a des paramètres
if(!isset($_GET['page'])) $optionPage = false;
else $optionPage = true;

// On détermine sur quelle page on se trouve
if((isset($_GET['page']) && !empty($_GET['page']))&& !isset($_POST['choices'])){
    $currentPage = (int) strip_tags($_GET['page']);
}
else{
    $currentPage = 1;
}

$breeds = [];
$housings = [];
$isVisible = 2;
$sort = null;
$perPage = 50;
$first = ($currentPage * $perPage) - $perPage;
$nbAnimals=0;

declareFilter($breeds, $housings, $isVisible, $sort, $first);
$animals = allAnimals($breeds, $housings, $isVisible, $sort, $first, $perPage,$nbAnimals);
$pages = ceil($nbAnimals / $perPage);