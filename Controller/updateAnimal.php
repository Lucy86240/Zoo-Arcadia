<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/updateAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once "Controller/ManageAnimal.php";

        /**
         * Summary of updateAnimal permet de mettre à jour un animal (nécessite un formulaire)
         * @param mixed $animal : tableau associatif de l'animal à modifier
         * @return string|null
         */
        function updateAnimal(&$animal){
            //on récupère les infos
            $id = $animal['id'];
            $name = $animal['name'];
            $nbPhoto = count($animal['images']);
            //on récupère le nom du bouton à cliquer pour modifier l'animal
            $nameButtonValid = "UpdateAnimal".$id;
            if(isset($_POST[$nameButtonValid]) && $_POST[$nameButtonValid]!=null){
                //on récupère la modification du nom (si besoin)
                $nameName ="updateAnimalName".$id;
                $name = '0';
                if(isset($_POST[$nameName]) && $_POST[$nameName]!='' && isAnimalName($_POST[$nameName])){
                    $name = $_POST[$nameName];
                    $_POST[$nameName] = null;
                }
    
                //on récupère la modification de l'habitat (si besoin)
                $nameHousing = "updateAnimalHousing".$id;
                $housing = 0;
                if(isset($_POST[$nameHousing]) && $_POST[$nameHousing]!=null && is_numeric($_POST[$nameHousing])){
                    $housing = $_POST[$nameHousing];
                    $_POST[$nameHousing] = null;
                }
    
                //on récupère la modification de la race (si besoin)
                $nameNewBreed = "newBreed".$id;
                $newBreed = 0;
                if(isset($_POST[$nameNewBreed]) && $_POST[$nameNewBreed]!='' && isAnimalName($_POST[$nameNewBreed])){
                    $newBreed = $_POST[$nameNewBreed];
                    $_POST[$nameNewBreed] = null;
                    $breed = addBreedRequest($newBreed);
                }
                if($newBreed==0){
                    $nameBreed = "updateAnimalBreed".$id;
                    $breed = 0;
                    if(isset($_POST[$nameBreed]) && $_POST[$nameBreed]!=null && is_numeric($_POST[$nameBreed])){
                        $breed = $_POST[$nameBreed];
                        $_POST[$nameBreed] = null;
                    }
                }
                //on met à jour la base de données avec les infos
                $msgUpdate = updateAnimalRequest($id,$name,$housing,$breed);
                
                //on ajoute la nouvelle photo
                $namePhoto = 'UpdateAnimalPhoto'.$id;
                if(isset($_FILES[$namePhoto]) && $_FILES[$namePhoto]['name'] !=''){
                    //on vérifie que l'image soit valide
                    $msgImg = validImg($_FILES[$namePhoto]);
                    if(validImg($_FILES[$namePhoto]) == null){
                        // on déplace la nouvelle photo
                        $name_file = explode('.',$_FILES[$namePhoto]['name']);
                        $extension = end($name_file);
                        $pathImg='View/assets/img/animals/'.$id.'-'.$name;
                        if(!file_exists( $pathImg )) mkdir($pathImg);
                        $path = 'View/assets/img/animals/'.$id.'-'.$name.'/'.$name.'-'.time().'.'.$extension;
                        if(move_uploaded_file($_FILES[$namePhoto]['tmp_name'],$path)==false){
                            $msgImgSave='error';
                        }
                        // on met à jour la base de données
                        $photo = new Image();
                        $photo->setPath($path);
                        $namePortrait = 'USP-checkboxPortrait'.$id;
                        $nameDescriptionImg = 'USP-Description'.$id;
                        $nameAttributionImg = 'USP-attribution'.$id;
                        $portrait = false;
                        $descImg = 'NULL';
                        $attribution = '';
                        if(isset($_POST[$nameDescriptionImg]) && isText($_POST[$nameDescriptionImg])) $descImg = $_POST[$nameDescriptionImg];
                        if(isset($_POST[$namePortrait])) $portrait = true;
                        if(isset($_POST[$nameAttributionImg])) $attribution = $_POST[$nameAttributionImg];
    
                        $photo->setDescription($descImg);
                        $photo->setPortrait($portrait);
                        $photo->setIcon(false);
                        $photo->setAttribution($attribution);
                        $msgImg= addImgRequest('animals',$id, $photo);
                    }
                    $_FILES[$namePhoto]=null;
                }
                
                //on supprime les photos selectionnées
                for($i=0 ; $i< $nbPhoto; $i++){
                    //on vérifie si la poubelle de la photo est cochée
                    if(isset($_POST["checkbox".$i]) && imageExistById($_POST["checkbox".$i])){
                        $id_image = $_POST["checkbox".$i];
                        //on récupère le chemin de la photo
                        $path = searchPathById($id_image);
                        //on supprime la photo dans le dossier
                        unlink($path);
                        //on supprime la photo dans la base de donnée
                        deleteImageRequest($id_image);
                    }
                }
                //on met à jour l'animal
                $animal = animalById($_GET['id'], false, false);
                if($msgUpdate=="success" && ((isset($msgImg) && $msgImg=="success" && !isset($msgImgSave)) || (!isset($msgImg)))){
                    return "success";
                }
                else if ($msgUpdate=="error" || (isset($msgImgSave) && $msgImgSave=="error") || (isset($msgImg) && $msgImg=="error")){
                    return "Oups! Une erreur est survenue nous n'avons pas pu mettre à jour l'animal...";
                }
                else return $msgImg;
    
            }
        }
    
        //on initialise l'animal
        $animal = animalById($_GET['id'], false, false);
        //on le met à jour et récupère le message de fin de traitement
        $msg = updateAnimal($animal);
}

