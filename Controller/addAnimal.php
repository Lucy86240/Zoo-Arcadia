<?php

if($_SERVER['REQUEST_URI']!='/Controller/addAnimal.php'){
    include_once "Controller/ManageAnimal.php";

    function addAnimal(){

        $animal = new Animal();
        $animal->setIsVisible(true);
        //on récupère le nom du bouton à cliquer pour modifier l'animal
        if(isset($_POST["addAnimal"]) && $_POST["addAnimal"]!=null){
            //on récupère le nom
            if(isset($_POST["newAnimalName"]) && $_POST["newAnimalName"]!=null){
                $animal->setName($_POST["newAnimalName"]);
                $_POST["newAnimalName"] = null;
            }

            //on récupère l'habitat
            if(isset($_POST["newAnimalHousing"]) && $_POST["newAnimalHousing"]!=null){
                $animal->setIdHousing($_POST["newAnimalHousing"]);
                $_POST["newAnimalHousing"] = null;
            }

            //on récupère la race
            $newBreed = 0;
            if(isset($_POST["newBreed"]) && $_POST["newBreed"]!=null && $_POST["newBreed"]!=''){
                $newBreed = $_POST["newBreed"];
                $_POST["newBreed"] = null;
                $animal->setIdBreed(addBreedRequest($newBreed));
            }
            if($newBreed==0){
                if(isset($_POST["newAnimalBreed"]) && $_POST["newAnimalBreed"]!=null){
                    $animal->setIdBreed($_POST["newAnimalBreed"]);
                    $_POST["newAnimalBreed"] = null;
                }
            }
            //on met à jour la base de données avec les infos
            $id=0;
            $msgNew = addAnimalRequest($animal,$id);
            
            //on ajoute la nouvelle photo
            if(isset($_FILES['newAnimalPhoto']) && $_FILES['newAnimalPhoto']['name'] !='' && $id!=0 && $msgNew != 'error'){
                //on vérifie que l'image soit valide
                $msgImg = validImg($_FILES['newAnimalPhoto']);
                if(validImg($_FILES['newAnimalPhoto']) == null){
                    // on déplace la nouvelle photo
                    $name_file = explode('.',$_FILES['newAnimalPhoto']['name']);
                    $extension = end($name_file);
                    $pathImg='View/assets/img/animals/'.$id.'-'.$animal->getName();
                    $path = 'View/assets/img/animals/'.$id.'-'.$animal->getName().'/'.$animal->getName().'-'.time().'.'.$extension;
                    mkdir($pathImg);
                    if(move_uploaded_file($_FILES['newAnimalPhoto']['tmp_name'],$path)==false){
                        $msgImgSave='error';
                    }
                    // on met à jour la base de données
                    $photo = new Image();
                    $photo->setPath($path);
                    $portrait = false;
                    $descImg = 'NULL';
                    if(isset($_POST['NSP-Description'])) $descImg = $_POST['NSP-Description'];
                    if(isset($_POST['NSP-checkboxPortrait'])) $portrait = $_POST['NSP-checkboxPortrait'];
                    $photo->setDescription($descImg);
                    $photo->setPortrait($portrait);
                    $photo->setIcon(false);
                    $msgImg= addImgRequest('animals',$id, $photo);
                }
                $_FILES['newAnimalPhoto']=null;
            }
            if($msgNew=="success" && ((isset($msgImg) && $msgImg=="success" && !isset($msgImgSave)) || (!isset($msgImg)))){
                return "success";
            }
            else if ($msgNew=="error" || (isset($msgImgSave) && $msgImgSave=="error") || (isset($msgImg) && $msgImg=="error")){
                return "Oups! Une erreur est survenue nous n'avons pas pu mettre à jour l'animal...";
            }
            else return $msgImg;

        }
    }

    $msg = addAnimal();
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}