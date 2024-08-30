<?php
//on execute le programme seulement si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageFood.php'){
    try{
        require_once "Controller/ManageAnimal.php";
        require_once "Model/ManageFedAnimalModel.php";
    
        /**
         * Summary of addFood : ajout d'un repas à la base de données (en fonction d'un formulaire)
         * @param mixed $animal : tableau asso de l'animal nourri
         * @param mixed $foods : tableau asso de repas à mettre à jour
         * @param mixed $perPage : nb repas par page (pour pagination)
         * @param mixed $first : 1er repas du tableau (pour pagination)
         * @return void
         */
        function addFood($animal, &$foods, $perPage, $first){
            //si on clique sur ajouter un repas
            if(isset($_POST['addFood']) && $_POST['addFood']!=null){
                $problem = false;
                //on récupère la date
                if(isset($_POST['dateFed']) && isDate($_POST['dateFed'])){
                    $date=$_POST['dateFed'];
                }
                else{
                    $problem = true;
                }
    
                //on récupère l'heure
                if(isset($_POST['hourFed'])){
                    $hour=$_POST['hourFed'];
                }
                else{
                    $problem = true;
                }
    
                //on récupère l'id de l'animal
                //via le formulaire
                if(isset($_POST['searchAnimalFed']) && is_numeric($_POST['searchAnimalFed'])){
                    $id_animal = $_POST['searchAnimalFed'];
                }
                else{
                    //on via l'animal entré en paramètre
                    if($animal != null && animalExistById($animal['id'])) $id_animal =$animal['id'];
                    else $problem = true;
                    $msg='Le repas n\'a pas été enregistré car vous devez sélectionner un animal';
                }
    
                //on récupère la nourriture donnée
                if(isset($_POST['foodFed']) && isText($_POST['foodFed'])){
                    $foodFed = $_POST['foodFed'];
                }
                else{
                    $problem = true;
                }
    
                //on récupère la quantité donnée
                if(isset($_POST['weightFed']) && isText($_POST['weightFed'])){
                    $weightFed = $_POST['weightFed'];
                }
                else{
                    $problem = true;
                }
    
                //si on a tous récupéré on ajoute le repas à la base de données
                if(!$problem){
                    addFedAnimalRequest($id_animal, $_SESSION['mail'],$date,$hour,$foodFed,$weightFed);
                    $_POST['addFood']=null;
                }
                //si on a un tableau de repas on le met à jour
                if($foods != null) filter($foods,$nbFoods,$perPage,$first);
            }
        }
    
        /**
         * Summary of changeFoodObjectToAssociatif : change un objet food en tableau associatif
         * @param FedAnimal $foodObject : objet à copier
         * @return array : tableau asso (employee,animal,date,hour,food,weight)
         */
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
        /**
         * Summary of allFoods retourne un tableau de repas en fonction de filtres
         * @param mixed $breeds  : tableau d'id de races ou []
         * @param mixed $animals : tableau d'id d'animaux ou []
         * @param mixed $employee : tableau d'id d'employés ou []
         * @param mixed $dateStart : date de début
         * @param mixed $dateEnd : date de fin
         * @param mixed $first : 1er repas du tableau (en cas de pagination)
         * @param mixed $nbFoods : nombre de repas à mettre dans le tableau
         * @return array : tableau asso de repas
         */
        function allFoods($breeds,$animals,$employee,$dateStart,$dateEnd, $first, $nbFoods){
            //on récupère les objets repas en fonction du filtre
            $FoodsObject=allFoodRequest($breeds,$animals,$employee,$dateStart,$dateEnd, $first, $nbFoods);
            //on transforme en tableau associatif
            $Foods=[];
            foreach($FoodsObject as $FoodObject){
                $Food = changeFoodObjectToAssociatif($FoodObject);
                array_push($Foods,$Food);
            }
            return $Foods;
        }
    
        /**
         * Summary of filter : filtre le tableau asso de repas en fonction des POST et SESSION
         * @param mixed $Foods : tableau asso de repas à modifier
         * @param mixed $nbFoods : nombre total de repas en fonction des filtres
         * @param mixed $perPage : nombre de repas dans le tableau
         * @param mixed $first : position du 1er repas à inclure dans le tableau (pour pagination)
         * @return void
         */
        function filter(&$Foods, &$nbFoods, $perPage, $first){
            //si on a filtré
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
    
                //filtre des employés
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
    
                //filtre des dates
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
    
                //on met à jour le tableau de repas et le nombre de repas total
                $Foods=allFoods($breeds,null,$employees,$dateStart,$dateEnd,null,$perPage);
                $nbFoods=countFoodFilter($breeds,null,$employees,$dateStart,$dateEnd);
    
            }
            else{
                //si on a pas cliqué sur filtrer on vérifie s'il n'existe pas un filtre antérieur
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
            //si on clique sur annuler le filtre
            if(isset($_POST['cancelFilter'])){
                $_SESSION['allFedAnimals_filterBreeds']=null;
                $_SESSION['allFedAnimals_filterdateEnd']=null;
                $_SESSION['allFedAnimals_filterdateStart']=null;
                $_SESSION['allFedAnimals_filteremployee']=null;
                $Foods = allFoods(null,null,null,null,null,$first,$perPage);
                $nbFoods=countFoodFilter(null,null,null,null,null);
            }
        }
    
        /**
         * Summary of urlOption : affiche le complément d'url avec les paramètres nécessaires
         * @param int $page : numéro de la page à mettre dans l'url
         * @param bool $optionPage : si des paramètres existent dans l'url actuel
         * @return void
         */
        function urlOption(int $page,bool $optionPage){
            $url="";
            if(!$optionPage) $url.="repas/";
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
                    else return '';
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
                if(!isset($_POST['choices']) && isset($_SESSION['allFedAnimals_filter'.$filter])) return $_SESSION['allFedAnimals_filter'.$filter];
                else return '';
            }
            
        }
    
        /**
         * Summary of displayFoods : permet l'affichage les repas
         * @param mixed $currentPage : page actuelle
         * @param mixed $perPage : nombre de repas par page
         * @param mixed $Foods : tableau asso de repas à afficher (qui sera mis à jour)
         * @param mixed $pages : nombre de pages (qui sera mis à jour)
         * @param mixed $nbFoods : nombre de repas total (qui sera mis à jour)
         * @param mixed $first : position du 1er repas du tableau (qui sera mis à jour)
         * @return void
         */
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
    
        //on indique si l'url actuel a des paramètres
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
    
        //on récupère les infos clés pour l'affichage des repas
        $foods=null;
        $pages=null;
        $nbFoods=0;
        $perPage=20;
        $first=null;
    
        //on affiche les repas
        displayFoods($currentPage,$perPage,$foods,$pages,$nbFoods,$first);
    
        //on permet d'ajouter un repas
        addFood(null,$foods,$perPage,$first);
    
        //on donne la liste des employés possibles
        $employees = listOfUserByRole(3);
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
    
}
else{
    //affichage de la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
        
