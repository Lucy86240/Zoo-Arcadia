<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/ManageMedicalReportsAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once "Controller/ManageMedicalReports.php";

        /**
         * Summary of filterExist indique si un filtre est appliqué
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
                if(isset($_POST['choices']) && isset($_POST['dateStart']) && isDate($_POST['dateStart'])) return $_POST['dateStart'];
                else return '';
            }
            if($filter=='dateEnd'){
                if(isset($_POST['choices']) && isset($_POST['dateEnd']) && isDate($_POST['dateEnd'])) return $_POST['dateEnd'];
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
            
            if(isset($_POST['choices']) && isset($_POST['limit']) && is_numeric($_POST['limit'])){
                $limit= $_POST['limit'];
            }
    
            if(isset($_POST['choices']) && isset($_POST['dateStart']) && isDate($_POST['dateStart'])){
                $dateStart = $_POST['dateStart'];
            }
    
            if(isset($_POST['choices']) && isset($_POST['dateEnd']) && isDate($_POST['dateEnd'])){
                $dateEnd = $_POST['dateEnd'];
            }
        }
    
        /**
         * Summary of animalFilter : renvoi un tableau associatif de l'animal selon les filtres médicaux
         * @param mixed $animal : le tableau associatif de l'animal dont les rapports sont à filtrer
         * @param mixed $dateStart : la date de début des rapports (null si pas de filtre)
         * @param mixed $dateEnd : la date de fin des rapports (null si pas de filtre)
         * @param mixed $limit : le nombre de rapports à afficher (null si pas de filtre)
         * @return array|null
         */
        function animalFilter($animal, $dateStart, $dateEnd, $limit){
    
            $animalFilter = animalById($animal['id'],false,false);
            $animalFilter['reports'] = [];
            $reports = medicalReportWithFilter($animal['id'],$dateStart,$dateEnd, $limit);
            foreach($reports as $reportRequest){
                $report = array(
                    'date' => $reportRequest['date'],
                    'health' => $reportRequest['health'],
                    'food' => $reportRequest['food'],
                    'weight_of_food' => $reportRequest['weight_of_food'],
                    'comment' => $reportRequest['comment'],
                    'veterinarian' => findNameofUser($reportRequest['veterinarian'])
                );
                array_push($animalFilter['reports'],$report);
            }
    
            return $animalFilter;
    
        }
    
        //initialisation des variables
        $animal = null;
        $filter = null;
    
        //si l'id de l'animal existe dans les paramètres de l'url
        if(isset($_GET['animal']) && is_numeric($_GET['animal'])){
            //initialisation de l'animal
            $animal=animalById($_GET['animal'],true,true);
            //modification de l'animal en cas de filtres
            if(filterExist()){
                $dateStart = null;
                $dateEnd = null;
                $limit = null;
                initialFilter($dateStart, $dateEnd, $limit);
                $animal = animalFilter($animal, $dateStart, $dateEnd, $limit);
            }
            //permet l'ajout de rapports
            $reports=null;
            $msg = null;
            $msg = addReport($animal,$reports,20,0);
        }
        else
        {
            echo("Nous n'arrivons pas à trouver l'animal");
        }
}