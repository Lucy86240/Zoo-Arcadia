<?php

include_once "Model/ManageServiceModel.php";

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

function AllServices(bool $id=false, bool $description=true){
        $servicesObject = AllServicesRequest();
        $services = [];
        $id = 0;
        foreach($servicesObject as $serviceObject){ 
            $service = array(
                "id_service" => $serviceObject->getId(),
                "name" => $serviceObject->getName(),
            );
            if($description == true){
                $service["description"] = $serviceObject->getDescription();
            }
            $service["icon"] = $serviceObject->getIcon();
            $service["photo"] = $serviceObject->getPhoto();

            $services[$id]=$service;
            $id++;
        }            
    return $services;
}

function addService(&$message){
    if(isset($_POST['addReview']) && $_POST['addReview']!=null){
        $_POST['addReview']=null;
        if(validImg($_FILES['NewServicePhoto'])==null && validIcon($_FILES['NewServiceIcon'])==null){
            $newService = new Service();
            $newService->setName($_POST['NewServiceName']);
            $newService->setDescription($_POST['NewServiceDescription']);
            $id=(addServiceRequest($newService));
            if($id != 0){
                $pathService = "View/assets/img/services/".$id.'/';
                mkdir($pathService);
                $pathIcon = $pathService.'icon.png';
                if(move_uploaded_file($_FILES['NewServiceIcon']['tmp_name'],$pathIcon)==false){
                    echo('error');
                }

                $imgIcon = new Image();
                $imgIcon->setPath($pathIcon);
                $imgIcon->setIcon(true);
                $imgIcon->setPortrait(false);
                $imgIcon->setDescription('Null');
                addImgRequest("services", $id, $imgIcon);

                $name_file = explode('.',$_FILES['NewServicePhoto']['name']);
                $extension = end($name_file);
                $pathImg = $pathService.'photo1.'.$extension;
                if(move_uploaded_file($_FILES['NewServicePhoto']['tmp_name'],$pathImg)==false){
                    echo('error');
                }

                $imgImg = new Image();
                $imgImg->setPath($pathImg);
                $imgImg->setIcon(false);
                if(isset($_POST["NSP-checkboxPortrait"])){
                    $imgImg->setPortrait(true);
                    $_POST["NSP-checkboxPortrait"] = null;
                } 
                else $imgImg->setPortrait(false);
                if(isset($_POST["NSP-Description"])){
                    $imgImg->setDescription($_POST["NSP-Description"]);
                    $_POST["NSP-Description"] = null;
                }
                else $imgImg->setDescription('Null');
                addImgRequest("services", $id, $imgImg);
                
            }
            $message="Le service \"".$_POST['NewServiceName']."\" a bien été ajouté.";
            return true;
        }
        else{
            $message=validImg($_FILES['NewServicePhoto']);
            $message.="<br>".validIcon($_FILES['NewServiceIcon']);
            return false;
        }
    }
}

function deleteService(int $id){
    $name_button = "ValidationDeleteService".$id;
    if(isset($_POST[$name_button]) && $_POST[$name_button]!=null){
        //suppression dans la base de données
        deleteServiceRequest($id);
        //suppression des images
        $path = "View/assets/img/services/".$id.'/';
        rrmdir($path);
        $_POST[$name_button]=null;
    } 
    
}

//génère les infos des services
$services = AllServices(true,true);

//gère la suppression de service
foreach($services as $service){
    deleteService($service['id_service']);
}
$services = AllServices(true,true);


