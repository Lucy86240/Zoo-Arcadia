<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/ManageService.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    try{
        require_once "Model/ManageServiceModel.php";
        /**
         * Summary of AllServices : permet d'obtenir un tableau associatif avec les éléments essentiels des services
         * @param bool $description : true = on souhaite avoir la description des services
         * @return array[] : retourne un tableau associatif avec les infos des services (id_service, name, description, icon, photo)
         */
        function allServices(bool $description=true){
            //on récupère les éléments de la base de données
            $servicesObject = AllServicesRequest();
    
            $services = [];
    
            //on regarde chaque objet pour mettre ses éléments dans le tableau associatif
            foreach($servicesObject as $serviceObject){ 
                $service = array(
                    "id_service" => $serviceObject->getId(),
                    "name" => $serviceObject->getName(),
                    "icon" => [],
                    "photo" => [],
                );
                //icon
                $service["icon"]["path"] = $serviceObject->getIcon()->getPath();
                $service["icon"]["attribution"] = echapHTML($serviceObject->getIcon()->getAttribution());
                $service["icon"]["description"] = $serviceObject->getIcon()->getDescription();
    
                $service["photo"]["path"] = $serviceObject->getPhoto()->getPath();
                $service["photo"]["attribution"] = echapHTML($serviceObject->getPhoto()->getAttribution());
                $service["photo"]["portrait"] = $serviceObject->getPhoto()->getPortrait();
                $service["photo"]["description"] = $serviceObject->getPhoto()->getDescription();
    
                if($description == true){
                    $service["description"] = $serviceObject->getDescription();
                }
    
                array_push($services,$service);
        }            
            return $services;
        }
    
        /**
         * Summary of addService : permet d'ajouter un service (nécessite un formulaire)
         * @param mixed $message : permet d'obtenir les messages d'erreurs des images ou le message de réussite du traitement
         * @return bool : retourne true si le service est créé
         */
        function addService(&$message){
            //on vérifie si on a cliqué sur ajouter un service
            if(isset($_POST['addService']) && $_POST['addService']!=null){
    
                //on réinitialise le bouton
                $_POST['addService']=null;
    
                //on vérifie que les images soient valides
                if(validImg($_FILES['NewServicePhoto'])==null && validIcon($_FILES['NewServiceIcon'])==null){
                    //on crée un objet service avec les infos saisies
                    $newService = new Service();
                    $newService->setName($_POST['NewServiceName']);
                    $newService->setDescription($_POST['NewServiceDescription']);
                    //on ajoute le service à la base de données et on récupère son id
                    $id=(addServiceRequest($newService));
                    if($id != 0){
                        //on créer le dossier qui contiendra les images
                        $pathService = "View/assets/img/services/".$id.'/';
                        mkdir($pathService);
                        //on ajoute l'icone à ce dossier
                        $pathIcon = $pathService.'icon.png';
                        if(move_uploaded_file($_FILES['NewServiceIcon']['tmp_name'],$pathIcon)==false){
                            echo('error');
                        }
                        //on créé un objet Image contenant les infos de l'icone
                        $imgIcon = new Image();
                        $imgIcon->setPath($pathIcon);
                        $imgIcon->setIcon(true);
                        $imgIcon->setPortrait(false);
                        $imgIcon->setDescription('Null');
                        if(isset($_POST['NSP-attributionIcon'])) $imgIcon->setAttribution($_POST['NSP-attributionIcon']);
                        addImgRequest("services", $id, $imgIcon);
    
                        //on ajoute la photo au dossier des images
                        $name_file = explode('.',$_FILES['NewServicePhoto']['name']);
                        $extension = end($name_file);
                        $pathImg = $pathService.'photo1.'.$extension;
                        if(move_uploaded_file($_FILES['NewServicePhoto']['tmp_name'],$pathImg)==false){
                            echo('error');
                        }
    
                        //on crée yun objet Image contenant les infos de la photo
                        $imgImg = new Image();
                        $imgImg->setPath($pathImg);
                        $imgImg->setIcon(false);
                        if(isset($_POST["NSP-checkboxPortrait"])){
                            $imgImg->setPortrait(true);
                            $_POST["NSP-checkboxPortrait"] = null;
                        } 
                        else $imgImg->setPortrait(false);
                        if(isset($_POST["NSP-Description"]) && isText($_POST["NSP-Description"])){
                            $imgImg->setDescription($_POST["NSP-Description"]);
                            $_POST["NSP-Description"] = null;
                        }
                        else $imgImg->setDescription('Null');
                        if(isset($_POST['NSP-attributionPhoto'])) $imgImg->setAttribution($_POST['NSP-attributionPhoto']);
                        addImgRequest("services", $id, $imgImg);
                        
                    }
                    //message indiquant qu'on a bien tout réussi
                    $message="Le service \"".$_POST['NewServiceName']."\" a bien été ajouté.";
                    return true;
                }
                else{
                    //messages indiquant les problèmes liés au images
                    $message=validImg($_FILES['NewServicePhoto']);
                    $message.="<br>".validIcon($_FILES['NewServiceIcon']);
                    return false;
                }
            }
            else{
                return false;
            }
        }
    
        /**
         * Summary of deleteService : permet de supprimer un service
         * @param int $id : id du service à supprimer
         * @return void
         */
        function deleteService(int $id){
            //on recupère le nom du bouton à cliquer pour supprimer le service
            $nameButton = "ValidationDeleteService".$id;
            //si on a cliqué sur le bouton
            if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
                //suppression dans la base de données
                deleteServiceRequest($id);
                //suppression des images
                $path = "View/assets/img/services/".$id.'/';
                rrmdir($path);
                $_POST[$nameButton]=null;
            } 
            
        }
    
        /**
         * Summary of updateService : permet de mettre à jour un service
         * @param mixed $service : élément du tableau associatif de la fonction allService à modifier
         * @return void
         */
        function updateService($service){
            //on récupère le nom du bouton à cliquer pour modifier ce service
            $nameButtonValid = "UpdateReview".$service['id_service'];
            if(isset($_POST[$nameButtonValid]) && $_POST[$nameButtonValid]!=null){
    
                //on récupère la modification de l'intitulé (si besoin)
                $nameName ="UpdateServiceName".$service['id_service'];
                $name = '';
                if(isset($_POST[$nameName]) && $_POST[$nameName]!='' && isAnimalName($_POST[$nameName])){
                    $name = $_POST[$nameName];
                    $_POST[$nameName] = null;
                }
    
                //on récupère la modification de la description (si besoin)
                $nameDescription = "UpdateServiceDescription".$service['id_service'];
                $description = '';
                if(isset($_POST[$nameDescription]) && $_POST[$nameDescription]!='' && isText($_POST[$nameDescription])){
                    $description = $_POST[$nameDescription];
                    $_POST[$nameDescription] = null;
                }
    
                //on met à jour la base de données avec les infos
                updateServiceRequest($service['id_service'],$name,$description);
    
                //on vérifie si il y a une nouvelle icone
                $nameIcon = 'UpdateServiceIcon'.$service['id_service'];
                if(isset($_FILES[$nameIcon]) && $_FILES[$nameIcon]['tmp_name'] !=''){
                    if(validIcon($_FILES[$nameIcon]) == null){
                        //on supprime l'ancienne
                        $path = 'View/assets/img/services/'.$service['id_service'].'/icon.png';
                        unlink($path);
                        //on déplace la nouvelle
                        if(move_uploaded_file($_FILES[$nameIcon]['tmp_name'],$path)==false){
                            echo('error');
                        }
                    }
                }
                    
                if(isset($_POST['USI-Attr'.$service['id_service']])){
                    //on cherche l'id de l'ancienne image
                    $id_image = searchIdImage('services',$service['id_service'],1);
                    //on modifie son attribution
                    $path = 'View/assets/img/services/'.$service['id_service'].'/icon.png';
                    if($id_image !=0) updateImageRequest($id_image, $path, '', 0, $_POST['USI-Attr'.$service['id_service']]);
                }
                
                $namePhoto = 'UpdateServicePhoto'.$service['id_service'];
                if(isset($_FILES[$namePhoto]) && $_FILES[$namePhoto]['tmp_name']!=''){
                    var_dump($_FILES[$namePhoto]['tmp_name']);
                    if(validImg($_FILES[$namePhoto]) == null){
                        //on supprime l'ancienne photo
                        unlink($service['photo']['path']);
                        // on déplace la nouvelle
                        $name_file = explode('.',$_FILES[$namePhoto]['name']);
                        $extension = end($name_file);
                        $path = 'View/assets/img/services/'.$service['id_service'].'/photo1.'.$extension;
                        if(move_uploaded_file($_FILES[$namePhoto]['tmp_name'],$path)==false){
                            echo('error');
                        }
                        // on met à jour la base de données
                        $namePortrait = 'USP-checkboxPortrait'.$service['id_service'];
                        $nameDescriptionImg = 'USP-Description'.$service['id_service'];
                        $nameAttrib = 'USP-Attr'.$service['id_service'];
                        $portrait = false;
                        $descImg = '';
                        $attr="";
                        if(isset($_POST[$nameDescriptionImg]) && isText($_POST[$nameDescriptionImg])) $descImg = $_POST[$nameDescriptionImg];
                        if(isset($_POST[$namePortrait])) $portrait = true;
                        if(isset($_POST[$nameAttrib])) $attr = $_POST[$nameAttrib];
    
                        //on cherche l'id de l'ancienne image
                        $id_image = searchIdImage('services',$service['id_service'],0);
                        //on modifie l'image
                        if($id_image !=0) updateImageRequest($id_image, $path, $descImg, $portrait, $attr);
                    }
                }
    
                //on réinitialise le bouton
                $_POST[$nameButtonValid]=null;
            } 
        }
    
        //on génère les infos des services
        $services = allServices(true);
    
        foreach($services as $service){
            //on gère la suppression de service
            deleteService($service['id_service']);
            //on gère la modification
            updateService($service);
        }
    
        //on regènére les infos des services après suppression / modification
        $services = allServices(true);
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page service...');
    }
}

