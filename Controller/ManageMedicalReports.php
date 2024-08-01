<?php

include_once "Controller/ManageAnimal.php";

function urlFilter(){
    $url ='';
    if(isset($_POST['choices']) && isset($_POST['limit'])){
        $url.='&limit='.$_POST['limit'];
    }
    else if(isset($_GET['limit'])){
        $url.='&limit='.$_GET['limit'];
    }
    if(isset($_POST['choices']) && isset($_POST['dateStart'])){
        $url.='&dateDebut='.$_POST['dateStart'];
    }
    else if(isset($_GET['dateDebut'])){
        $url.='&dateDebut='.$_GET['dateDebut'];
    }
    if(isset($_POST['choices']) && isset($_POST['dateEnd'])){
        $url.='&dateFin='.$_POST['dateEnd'];
    }
    else if(isset($_GET['dateFin'])){
        $url.='&dateFin='.$_GET['dateFin'];
    }
    return $url;
}

/**
 * Summary of filterExist indique si un filtre est appliqué
 * @return bool
 */
function filterExist(){
    if(isset($_GET['dateDebut']) || isset($_GET['dateFin']) || isset($_GET['limit']) ||
    isset($_POST['dateEnd']) || isset($_POST['dateStart']) || isset($_POST['limit'])) return true;
    else return false;
}

function defaultValue($filter){
    if($filter=="limit"){
        if(isset($_POST['choices']) && isset($_POST['limit'])) return $_POST['limit'];
        else if(isset($_GET['limit'])) return $_GET['limit'];
        else return '';
    }
    if($filter=="dateStart"){
        if(isset($_POST['choices']) && isset($_POST['dateStart'])) return $_POST['dateStart'];
        else if(isset($_GET['dateDebut'])) return $_GET['dateDebut'];
        else return '';
    }
    if($filter=='dateEnd'){
        if(isset($_POST['choices']) && isset($_POST['dateEnd'])) return $_POST['dateEnd'];
        else if(isset($_GET['dateFin'])) return $_GET['dateFin'];
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
    else if(isset($_GET['limit'])){
        $limit = $_GET['limit'];
    }

    if(isset($_POST['choices']) && isset($_POST['dateStart'])){
        $dateStart = $_POST['dateStart'];
    }
    else if(isset($_GET['dateDebut'])){
        $dateStart = $_GET['dateDebut'];
    }

    if(isset($_POST['choices']) && isset($_POST['dateEnd'])){
        $dateEnd = $_POST['dateEnd'];
    }
    else if(isset($_GET['dateFin'])){
        $dateEnd = $_GET['dateFin'];
    }
}

/**
 * Summary of animalFilter
 * @param mixed $animal : le tableau associatif de l'animal dont les rapports sont à filtrer
 * @param mixed $dateStart : la date de début des rapports (null si pas de filtre)
 * @param mixed $dateEnd : la date de fin des rapports (null si pas de filtre)
 * @param mixed $limit : le nombre de rapports à afficher (null si pas de filtre)
 * @return array|null
 */
function animalFilter($animal, $dateStart, $dateEnd, $limit){

    $animalFilter = animalById($animal['id'],false);
    $animalFilter['reports'] = [];

    if($dateStart != null && $dateEnd != null){
        foreach($animal['reports'] as $medicalReport){
            if($medicalReport['date'] >= $dateStart && 
            $medicalReport['date'] <= $dateEnd) 
                array_push($animalFilter['reports'],$medicalReport);
        }
    }
    else if($dateStart !=null){
        foreach($animal['reports'] as $medicalReport){
            if($medicalReport['date'] >= $dateStart) array_push($animalFilter['reports'],$medicalReport);
        }
    }
    else{
        foreach($animal['reports'] as $medicalReport){
            if($medicalReport['date'] <= $dateStart) array_push($animalFilter['reports'],$medicalReport);
        }
    }
    if($limit != null){

    }

    return $animalFilter;

}

$animal = null;
$filter = null;

if(isset($_GET['animal'])){
    $animal=animalById($_GET['animal'],true);
    if(filterExist()){
        $dateStart = null;
        $dateEnd = null;
        $limit = null;
        initialFilter($dateStart, $dateEnd, $limit);
        $animal = animalFilter($animal, $dateStart, $dateEnd, $limit);
    }
}
else
{
    echo("Nous n'arrivons pas à trouver l'animal");
}