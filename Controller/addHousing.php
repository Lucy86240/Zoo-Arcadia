<?php
//on execute le code si on est sur un url différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/addHousing.php'){
    try{
        require_once "Controller/ManageHousing.php";

        /**
         * Summary of addHousing : ajoute un habitat (s'utilise sur la page ajout habitat)
         * @return string|null retourne un msg 'sucess' ou le détail de l'erreur
         */
        function addHousing(){
            $housing = new Housing();
            
            //si on a cliqué sur le bouton d'ajout d'un habitat
            if(isset($_POST["addHousing"]) && $_POST["addHousing"]!=null){
                //on récupère le nom
                if(isset($_POST["newHousingName"]) && $_POST["newHousingName"]!='' && isAnimalName($_POST["newHousingName"])){
                    $housing->setName($_POST["newHousingName"]);
                    $_POST["newHousingName"] = null;
                }
    
                //on récupère la description
                if(isset($_POST["newHousingDescription"]) && $_POST["newHousingDescription"]!='' && isText($_POST["newHousingDescription"])){
                    $housing->setDescription($_POST["newHousingDescription"]);
                    $_POST["newHousingDescription"] = null;
                }
    
                //on met à jour la base de données avec les infos
                $id=0;
                $msgNew = addHousingRequest($housing,$id);
                
                //on ajoute la photo
                if(isset($_FILES['newHousingPhoto']) && $_FILES['newHousingPhoto']['name'] !='' && $id!=0 && $msgNew != 'error'){
                    //on vérifie que l'image soit valide
                    $msgImg = validImg($_FILES['newHousingPhoto']);
                    if(validImg($_FILES['newHousingPhoto']) == null){
                        // on déplace la photo
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
                        $att ='';
                        if(isset($_POST['NSP-Description']) && isText($_POST['NSP-Description'])) $descImg = $_POST['NSP-Description'];
                        if(isset($_POST['NSP-checkboxPortrait'])) $portrait = true;
                        if(isset($_POST['NSP-attribution'])) $att = $_POST['NSP-attribution'];
                        $photo->setDescription($descImg);
                        $photo->setPortrait($portrait);
                        $photo->setAttribution($att);
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
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    //affiche page 404 si on est sur le chemin du fichier
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}