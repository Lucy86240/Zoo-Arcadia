<?php

// on execute le programme que si l'url est différent du chemin de la page
if($_SERVER['REQUEST_URI']!='/Controller/addAnimal.php'){
    try{
        require_once "Controller/ManageAnimal.php";

        /**
         * Summary of addAnimal : ajoute un animal
         * @return string|null : au besoin retourne un msg d'erreur
         */
        function addAnimal(){
            $animal = new Animal();
            $animal->setIsVisible(true);
            //si on a cliqué sur ajouter un animal
            if(isset($_POST["addAnimal"]) && $_POST["addAnimal"]!=null){
                //on récupère le nom
                if(isset($_POST["newAnimalName"]) && $_POST["newAnimalName"]!='' && isAnimalName($_POST["newAnimalName"]) ){
                    $animal->setName($_POST["newAnimalName"]);
                    $_POST["newAnimalName"] = null;
                }
                //on récupère l'habitat
                if(isset($_POST["newAnimalHousing"]) && $_POST["newAnimalHousing"]!=null && is_numeric($_POST["newAnimalHousing"])){
                    $animal->setIdHousing($_POST["newAnimalHousing"]);
                    $_POST["newAnimalHousing"] = null;
                }

                //on récupère la race
                $newBreed = 0;

                //dans le cas où on a saisi une nouvelle race
                if(isset($_POST["newBreed"]) && $_POST["newBreed"]!=null && $_POST["newBreed"]!='' && isName($_POST["newBreed"])){
                    $newBreed = $_POST["newBreed"];
                    $_POST["newBreed"] = null;
                    $animal->setIdBreed(addBreedRequest($newBreed));
                }
                // dans le cas où on a cliqué sur une race existante
                if($newBreed==0){
                    if(isset($_POST["newAnimalBreed"]) && $_POST["newAnimalBreed"]!=null && is_numeric($_POST["newAnimalBreed"])){
                        $animal->setIdBreed($_POST["newAnimalBreed"]);
                        $_POST["newAnimalBreed"] = null;
                    }
                }
                //on met à jour la base de données avec les infos
                $id=0;
                $msgNew = addAnimalRequest($animal,$id);
                
                //on ajoute la photo
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
                        $att ='';
                        if(isset($_POST['NSP-Description']) && isText($_POST['NSP-Description'])) $descImg = $_POST['NSP-Description'];
                        if(isset($_POST['NSP-checkboxPortrait'])) $portrait = true;
                        if(isset($_POST['NSP-attribution'])) $att = $_POST['NSP-attribution'];
                        $photo->setDescription($descImg);
                        $photo->setPortrait($portrait);
                        $photo->setAttribution($att);
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
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    // on affiche erreur 404 si on se trouve sur le chemin du fichier
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}