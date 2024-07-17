<?php

include_once "Model/Service.php";
include_once "Model/Image.php";
function allServicesRequest(){
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

                $stmtIcon = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=true');
                $stmtIcon->bindParam(":id", $id, PDO::PARAM_INT);
                $stmtIcon->setFetchMode(PDO::FETCH_CLASS,'Image');
                if ($stmtIcon->execute())
                {
                    $image = $stmtIcon->fetch();
                    $services[$indice]->setIcon($image);
                }

                $stmtPhoto = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=0');
                $stmtPhoto->bindParam(":id", $id, PDO::PARAM_INT);
                $stmtPhoto->setFetchMode(PDO::FETCH_CLASS,'Image');
                if ($stmtPhoto->execute()){                    
                    $image = $stmtPhoto->fetch();
                    $services[$indice]->setPhoto($image);
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

function addServiceRequest(Service $service){
    try{
        $name = $service->getName();
        $description = $service->getDescription();
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('insert into services (name, description) VALUES (:name, :description)');
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT id_service FROM services WHERE name = :name and description = :description');
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['id_service'];
    }
    catch(error $e){
        echo("problème avec les données");
        return 0;
    }
}

function deleteServiceRequest(int $id){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');

        //on cherche toutes les images associées au service
        $stmt = $pdo->prepare('SELECT id_image FROM images_services WHERE id_service = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //on supprime toutes les images
        if($res != null){
            foreach ($res as $id_image){
                echo($id_image);
                $stmt = $pdo->prepare('DELETE FROM images WHERE id_image = :id');
                $stmt->bindParam(":id", $id_image, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        //on supprime le service
        $stmt = $pdo->prepare('DELETE FROM services WHERE id_service = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    catch(error $e){
        echo("problème avec les données");
    }
}