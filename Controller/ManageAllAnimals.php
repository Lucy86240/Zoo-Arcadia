<?php 
//on execute le programme que si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageAllAnimals.php'){
    try{
        require_once "Controller/ManageAnimal.php";

        /**
         * Summary of allAnimals retourne un tableau associatif d'animaux en fonction du filtre choisi
         * @param mixed $breeds : tableau des id des races souhaités
         * @param mixed $housings : tableau des id des habitats souhaités
         * @param mixed $isVisible : 0 archivé 1 visible 2 les 2
         * @param mixed $sort : trie du tableau 'housing' ou 'breed' par défaut id des animaux
         * @param mixed $first : à partir duquel animal commence le tableau (utile si +sieurs pages)
         * @param mixed $perPage : nombre d'animaux composant le tableau
         * @param mixed $nbAnimals : la fonction indique dans cette variable le nombre total d'animaux suivant le filtre
         * @return array tableau d'animaux :id,name,breed,housing,isVisible,photo
         */
        function allAnimals($breeds, $housings, $isVisible, $sort, $first, $perPage, &$nbAnimals){
            $animals = [];
            //on récupère un tableau d'object d'animaux avec le filtre souhaité
            $animalsObject = listAnimalsWithFilter($breeds, $housings, $isVisible, $sort, $first, $perPage, $nbAnimals);
            // on crée le tableau associatif en fonction des objets
            foreach($animalsObject as $animalObject){
                $animal['id'] = $animalObject->getId();
                $animal['name'] = $animalObject->getName();
                $animal['breed'] = $animalObject->getBreed();
                $animal['housing'] = $animalObject->getIdHousing();
                $animal['isVisible'] = $animalObject->getIsVisible();
                $animal['photo'] = $animalObject->getImage(0);
                //on renseigne le tableau de photo s'il y en a
                if($animalObject->countImages()>0){
                    $animal['photo']=[];
                    $animal['photo']['path'] = $animalObject->getImage(0)->getPath();
                    $animal['photo']['description'] = $animalObject->getImage(0)->getDescription();
                } else{
                    //si l'animal n'a pas de photo on met celle par défaut
                    $animal['photo']=[];
                    $animal['photo']['path'] = IMG_DEFAULT_ANIMAL;
                    $animal['photo']['description'] = "";
                }
                array_push($animals,$animal);
            }    
            return $animals;
        }
    
        /**
         * Summary of defaultValueCheckbox : indique checked si la case doit être cochée sinon rien
         * @param string $filter : nom de la checkbox
         * @param mixed $value : valeur qu'a la checkbox
         * @return string : '' ou 'checked'
         */
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
                    else return '';
                }
                else return '';
            }
        }
    
        /**
         * Summary of declareFilter permet d'initialiser les variables présentes dans les paramétres
         * @param mixed $breeds : retourne un tableau d'id de race
         * @param mixed $housings : retourne un tableau d'id d'habitats
         * @param mixed $isVisible : retourne 0,1 ou 2
         * @param mixed $sort : retourne '','housings','breeds'
         * @param mixed $first : retourne le 1er animal à afficher
         * @return void
         */
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
                $_SESSION['allAnimals_animalSelected']=null;
            }
        }
    
        /**
         * Summary of urlOption : affiche l'url on fonction de la pagination
         * @param mixed $page : numéro de la page
         * @param bool $optionPage : indique si la page actuelle dispose déjà d'un GET
         * @return void
         */
        function urlOption($page,bool $optionPage){
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
    
        //on initialise les les filtres/tries/animaux à afficher
        $breeds = [];
        $housings = [];
        $isVisible = 2;
        $sort = null;
        $perPage = 50;
        $first = ($currentPage * $perPage) - $perPage;
        $nbAnimals=0;
    
        declareFilter($breeds, $housings, $isVisible, $sort, $first);
        
        //seul les utilisateurs connectés peuvent voir les animaux archivés
        if(authorize(['connected'])){
            $animals = allAnimals($breeds, $housings, $isVisible, $sort, $first, $perPage,$nbAnimals);
        }
        else{
            $animals = allAnimals($breeds, $housings, 1, $sort, $first, $perPage,$nbAnimals);
        }
        //nombre de page
        $pages = ceil($nbAnimals / $perPage);
    
        // on affiche un animal si l'utilisateur a cliqué dessus
        if(isset($_POST['animalSelected'])) $_SESSION['allAnimals_animalSlected']=$_POST['animalSelected'];
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    //on affiche la page 404 si l'url correspond au chemin du fichier
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}