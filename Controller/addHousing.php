<?php

include_once "Controller/ManageHousing.php";

function addHousing(){

    $housing = new Housing();
    
    //on récupère le nom du bouton à cliquer pour créer l'habitat
    if(isset($_POST["addHousing"]) && $_POST["addHousing"]!=null){
        //on récupère le nom
        if(isset($_POST["newHousingName"]) && $_POST["newHousingName"]!=null){
            $housing->setName($_POST["newHousingName"]);
            $_POST["newHousingName"] = null;
        }

        //on récupère le nom
        if(isset($_POST["newHousingDescription"]) && $_POST["newHousingDescription"]!=null){
            $housing->setDescription($_POST["newHousingDescription"]);
            $_POST["newHousingDescription"] = null;
        }

        //on met à jour la base de données avec les infos
        $id=0;
        $msgNew = addHousingRequest($housing,$id);
        
        //on ajoute la nouvelle photo
        if(isset($_FILES['newHousingPhoto']) && $_FILES['newHousingPhoto']['name'] !='' && $id!=0 && $msgNew != 'error'){
            //on vérifie que l'image soit valide
            $msgImg = validImg($_FILES['newHousingPhoto']);
            if(validImg($_FILES['newHousingPhoto']) == null){
                // on déplace la nouvelle photo
                $name_file = explode('.',$_FILES['newHousingPhoto']['name']);
                $extension = end($name_file);
                $pathImg='View/assets/img/housings/'.$id;
                $path = 'View/assets/img/housings/'.$id.'/'.$housing->getName().'-'.time().'.'.$extension;
                mkdir($pathImg);
                if(move_uploaded_file($_FILES['newHousingPhoto']['tmp_name'],$path)==false){
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
                $msgImg= addImgRequest('housings',$id, $photo);
            }
            $_FILES['newHousingPhoto']=null;
        }
        if($msgNew=="success" && ((isset($msgImg) && $msgImg=="success" && !isset($msgImgSave)) || (!isset($msgImg)))){
            return "success";
        }
        else if ($msgNew=="error" || (isset($msgImgSave) && $msgImgSave=="error") || (isset($msgImg) && $msgImg=="error")){
            return "Oups! Une erreur est survenue nous n'avons pas pu créer l'habitat...";
        }
        else return $msgImg;

    }
}

$msg = addHousing();