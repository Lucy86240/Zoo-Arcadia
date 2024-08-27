<?php
if($_SERVER['REQUEST_URI']=='/Controller/updateHousing.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    include_once "Controller/ManageHousing.php";

    function updateHousing(&$housing){
        $id = $housing['id'];
        $name = $housing['name'];
        $description = $housing['description'];

        if(isset($housing['images'])) $nbPhoto = count($housing['images']);
        else $nbPhoto=0;
        
        if(isset($_POST["updateHousing"]) && $_POST["updateHousing"]!=null){
            //on récupère la modification du nom (si besoin)
            $name = '0';
            if(isset($_POST["updateHousingName"]) && $_POST["updateHousingName"]!=null){
                $name = $_POST["updateHousingName"];
                $_POST["updateHousingName"] = null;
            }
            //on récupère la modification du nom (si besoin)
            $description = '0';
            if(isset($_POST["updateHousingDescription"]) && $_POST["updateHousingDescription"]!=null){
                $description = $_POST["updateHousingDescription"];
                $_POST["updateHousingDescription"] = null;
            }

            //on met à jour la base de données avec les infos
            $msgUpdate = updateHousingRequest($id,$name,$description);
            
            //on ajoute la nouvelle photo
            $namePhoto = 'UpdateHousingPhoto'.$id;
            if(isset($_FILES[$namePhoto]) && $_FILES[$namePhoto]['name'] !=''){
                //on vérifie que l'image soit valide
                $msgImg = validImg($_FILES[$namePhoto]);
                if(validImg($_FILES[$namePhoto]) == null){
                    // on déplace la nouvelle photo
                    $name_file = explode('.',$_FILES[$namePhoto]['name']);
                    $extension = end($name_file);
                    $pathImg='View/assets/img/housings/'.$id.'-'.$name;
                    if(!file_exists( $pathImg )) mkdir($pathImg);
                    $path = 'View/assets/img/housings/'.$id.'-'.$name.'/'.$name.'-'.time().'.'.$extension;
                    if(move_uploaded_file($_FILES[$namePhoto]['tmp_name'],$path)==false){
                        $msgImgSave='error';
                    }
                    // on met à jour la base de données
                    $photo = new Image();
                    $photo->setPath($path);
                    $namePortrait = 'UHP-checkboxPortrait'.$id;
                    $nameDescriptionImg = 'UHP-Description'.$id;
                    $portrait = false;
                    $descImg = 'NULL';
                    if(isset($_POST[$nameDescriptionImg])) $descImg = $_POST[$nameDescriptionImg];
                    if(isset($_POST[$namePortrait])) $portrait = $_POST[$namePortrait];
                    $photo->setDescription($descImg);
                    $photo->setPortrait($portrait);
                    $photo->setIcon(false);
                    $msgImg= addImgRequest('housings',$id, $photo);
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
            $housing = housingArrayAssociation($_GET['id']);
            if($msgUpdate=="success" && ((isset($msgImg) && $msgImg=="success" && !isset($msgImgSave)) || (!isset($msgImg)))){
                return "success";
            }
            else if ($msgUpdate=="error" || (isset($msgImgSave) && $msgImgSave=="error") || (isset($msgImg) && $msgImg=="error")){
                return "Oups! Une erreur est survenue nous n'avons pas pu mettre à jour l'housing...";
            }
            else return $msgImg;

        }
    }

    $housing = housingArrayAssociation($_GET['id']);

    $msg = updatehousing($housing);
}