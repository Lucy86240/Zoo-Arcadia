<?php

include_once "Controller/ManageFood.php";

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
 * Summary of animalFilter : renvoi un tableau associatif de l'animal selon les filtres médicaux
 * @param mixed $animal : le tableau associatif de l'animal dont les rapports sont à filtrer
 * @param mixed $dateStart : la date de début des rapports (null si pas de filtre)
 * @param mixed $dateEnd : la date de fin des rapports (null si pas de filtre)
 * @param mixed $limit : le nombre de rapports à afficher (null si pas de filtre)
 * @return array|null
 */
function animalFilter($animal, $dateStart, $dateEnd, $limit){

    $animalFilter = animalById($animal['id'],false,false);
    $animalFilter['foods'] = [];
    $foods = foodWithFilter($animal['id'],$dateStart,$dateEnd, $limit);
    var_dump($foods);
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

$animal = null;
$filter = null;

if(isset($_GET['animal'])){
    $animal=animalById($_GET['animal'],false,true);
    if(filterExist()){
        $dateStart = null;
        $dateEnd = null;
        $limit = null;
        initialFilter($dateStart, $dateEnd, $limit);
        $animal = animalFilter($animal, $dateStart, $dateEnd, $limit);
    }
    $foods=null;
    addFood($animal,$reports,50,0);
}
else
{
    echo("Nous n'arrivons pas à trouver l'animal");
}