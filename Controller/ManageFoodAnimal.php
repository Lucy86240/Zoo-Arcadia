<?php
//execution du programme seulement si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageFoodAnimal.php'){
        require_once "Controller/ManageFood.php";

        /**
         * Summary of filterExist indique si un filtre est appliqué aux repas
         * @return bool
         */
        function filterExist(){
            if(isset($_POST['dateEnd']) || isset($_POST['dateStart']) || isset($_POST['limit'])) return true;
            else return false;
        }
    
        /**
         * Summary of defaultValue : retourne la valeur de l'input suivant ce qui a été validé préalablement
         * @param string $filter : valeurs possibles : limit dateStart dateEnd
         * @return mixed
         */
        function defaultValue(string $filter){
            if($filter=="limit"){
                if(isset($_POST['choices']) && isset($_POST['limit'])) return $_POST['limit'];
                else return '';
            }
            if($filter=="dateStart"){
                if(isset($_POST['choices']) && isset($_POST['dateStart'])) return $_POST['dateStart'];
                else return '';
            }
            if($filter=='dateEnd'){
                if(isset($_POST['choices']) && isset($_POST['dateEnd'])) return $_POST['dateEnd'];
                else return '';
            }
        }
    
        /**
         * Summary of initialFilter : donne les valeurs aux variables suivant les GET/POST en cours
         * @param mixed $dateStart : variable pour le filtre de la date de début
         * @param mixed $dateEnd : variable pour le filtre de la date de fin
         * @param mixed $limit : variable pour le filter du nombre max de rapport
         * @return void
         */
        function initialFilter(&$dateStart, &$dateEnd, &$limit){
            
            if(isset($_POST['choices']) && isset($_POST['limit'])){
                $limit= $_POST['limit'];
            }
    
            if(isset($_POST['choices']) && isset($_POST['dateStart'])){
                $dateStart = $_POST['dateStart'];
            }
    
            if(isset($_POST['choices']) && isset($_POST['dateEnd'])){
                $dateEnd = $_POST['dateEnd'];
            }
        }
    
        /**
         * Summary of animalFilter : renvoi un tableau associatif de l'animal selon les filtres de repas
         * @param mixed $animal : le tableau associatif de l'animal dont les repas sont à filtrer
         * @param mixed $dateStart : la date de début des repas (null si pas de filtre)
         * @param mixed $dateEnd : la date de fin des repas (null si pas de filtre)
         * @param mixed $limit : le nombre de repas à afficher (null si pas de filtre)
         * @return array|null
         */
        function animalFilter($animal, $dateStart, $dateEnd, $limit){
    
            $animalFilter = animalById($animal['id'],false,false);
            $animalFilter['foods'] = [];
            $foods = foodWithFilter($animal['id'],$dateStart,$dateEnd, $limit);
            foreach($foods as $foodRequest){
                $food = array(
                    'date' => $foodRequest->getDate(),
                    'hour' => $foodRequest->getHour(),
                    'food' => $foodRequest->getFood(),
                    'weight' => $foodRequest->getWeight(),
                    'employee' => findNameofUser($foodRequest->getIdEmployee())
                );
                array_push($animalFilter['foods'],$food);
            }
    
            return $animalFilter;
    
        }
    
        //initialisation des variables
        $animal = null;
        $filter = null;
    
        //dans le cas où le paramètre d'id existe dans l'url
        if(isset($_GET['animal'])){
            //l'animal est celui ayant pour id l'id du GET
            $animal=animalById($_GET['animal'],false,true);
            //on initialise les filtres
            if(filterExist()){
                $dateStart = null;
                $dateEnd = null;
                $limit = null;
                initialFilter($dateStart, $dateEnd, $limit);
                //on met a jour l'animal en fonction des filtres
                $animal = animalFilter($animal, $dateStart, $dateEnd, $limit);
            }
            $foods=null;
            $msg=null;
            //on permet d'ajouter un repas si nécessaire
            $msg = addFood($animal,$foods,50,0);
        }
        else
        {
            //si pas d'animal trouvé
            echo("Nous n'arrivons pas à trouver l'animal");
        }
}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}