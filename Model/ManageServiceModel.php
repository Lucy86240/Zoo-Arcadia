<?php

include_once "Model/Service.php";
include_once "Model/Image.php";
function allServices(bool $justIcon=false){
    try{
        $services = [];
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT * FROM services');
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Service');
        if($stmt->execute()){
            while($service = $stmt->fetch()){
                array_push($services,$service);
                $indice=count($services)-1;
                $id = $services[$indice]->getId();
                if($justIcon == true){
                    $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                    FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=true');
                }
                else{
                    $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                    FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=0');
                }
                $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                if ($stmt2->execute())
                {
                    while($image = $stmt2->fetch()){
                            $services[$indice]->addImage($image);
                    }
                }
            }
        }
        return $services;
    }
    catch (error $e){
        echo "Désolée";
        return new Service();
    }
}