<?php

include_once "Model/ManageServiceModel.php";

function AllServicesView(bool $id=false, bool $description=true, int $nbImgs=-1, bool $portraitAccept=true, bool $iconJust){
        $servicesObject = AllServices($iconJust);
        $services = [];
        $id = 0;
        foreach($servicesObject as $serviceObject){ 
            $service = array(
                "name" => $serviceObject->getName(),
            );
            if($description == true){
                $service["description"] = $serviceObject->getDescription();
            }

            //ajout du nombre d'images souhaitées
            if ($nbImgs == -1 || $nbImgs > $serviceObject->countImages() ){
                $nb = $serviceObject->countImages();
            }
            else{
                $nb = $nbImgs;
            }
            $service["images"] = [];
            for($i=0 ; $i<$nb; $i++){
                $img= array(
                    "path" => $serviceObject->getImage($i)->getPath(),
                    "description" => $serviceObject->getImage($i)->getDescription(),
                );
                array_push($service["images"],$img);
            }

            $services[$id]=$service;
            $id++;
        }            
    return $services;
    }