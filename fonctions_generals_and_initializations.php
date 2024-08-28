<?php

/**
 * Summary of rrmdir : supprime tous les éléments d'un dosser
 * @param mixed $dir : dossier à supprimer
 * @return void
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Summary of now : retourne la date du jour
 * @return string
 */
function now(){
    $now = date('Y-m-d',time());
    return $now;
}

function nowHour(){
    $now = date('H:i',time());
    return $now;
}

function isName($name){
    return preg_match_all("/^([a-zA-Zèéëïç\- ])+$/",$name);
}

function isAnimalName($name){
    return preg_match_all("/^([a-zA-Z0-9èéëïç\- ])+$/",$name);
}

function isText($txt){
    return preg_match_all("/^([a-zA-Z0-9èéëï^êç&!?,.:;\(\)\-\' ])+$/",$txt);
}

function isMail($mail){
    return preg_match_all("/^[a-zA-Z0-9_.±]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/",$mail);
}

function isDate($date){
    return preg_match_all("/[1-9][0-9][0-9]{2}-([0][1-9]|[1][0-2])-([1-2][0-9]|[0][1-9]|[3][0-1])/",$date);
}

function echapHTML($text){
    $newtext = str_replace("<","&lt;",$text);
    $newtext = str_replace(">","&gt;",$newtext);
    $newtext = str_replace("\"","&quot;",$newtext);
    return $newtext;
}

$pageHousing = false;
if(substr($_SERVER['REQUEST_URI'],0,9)=='/habitats') $pageHousing = true;

if($pageHousing == false){
    include_once "Model/ManageHousingModel.php";
    $listOfHousings = listIdAllHousings();
    for($i=0;$i<count($listOfHousings);$i++){
        $_SESSION['animal'.$listOfHousings[$i]]=null;
    }
}

$pageAllAnimals=false;
if(substr($_SERVER['REQUEST_URI'],0,8)=='/animaux') $pageAllAnimals = true;

if($pageAllAnimals == false){
    $_SESSION['allAnimals_filterBreeds']=[];
    $_SESSION['allAnimals_filterhousings']=[];
    $_SESSION['allAnimals_filterIsVisible']=2;
    $_SESSION['allAnimals_sort']=null;
    $_SESSION['allAnimals_animalSelected']=null;
}
