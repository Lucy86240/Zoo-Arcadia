<?php
if($_SERVER['REQUEST_URI']=='/Model/ManageServiceModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    include_once "Model/Service.php";
    include_once "Model/Image.php";

    /**
     * Summary of serviceExistById : vérifie l'existance de l'id dans la table service
     * @param int $id : $id du service à vérifier
     * @return bool : retourne true si l'id est trouvé, false sinon
     */
    function serviceExistById(int $id){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT id_service FROM services WHERE id_service = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res != null) return true;
            else return false;
        }
        catch(error $e){
            echo('erreur de bd');
            return false;
        }
    }
    /**
     * Summary of allServicesRequest : retourne un tableau avec tous les objets services de la base de données
     * @return array|Service
     */
    function allServicesRequest(){
        try{
            $services = [];
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM services');
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Service');
            if($stmt->execute()){

                //ajoute chaque ligne du résultat de la requête dans un tableau de services
                while($service = $stmt->fetch()){
                    array_push($services,$service);
                    $indice=count($services)-1;
                    $id = $services[$indice]->getId();

                    //recherche l'icone du service en cours d'ajout d'ajout dans le tableau
                    $stmtIcon = $pdo->prepare('SELECT images.* 
                    FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=true');
                    $stmtIcon->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmtIcon->setFetchMode(PDO::FETCH_CLASS,'Image');
                    
                    //ajoute l'icone trouvée
                    if ($stmtIcon->execute())
                    {
                        $image = $stmtIcon->fetch();
                        $services[$indice]->setIcon($image);
                    }

                    //recherche la photo du service
                    $stmtPhoto = $pdo->prepare('SELECT images.* 
                    FROM images_services JOIN images ON images_services.id_image = images.id_image  WHERE id_service = :id and images.icon=0');
                    $stmtPhoto->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmtPhoto->setFetchMode(PDO::FETCH_CLASS,'Image');
                    //ajoute la photo trouvée
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

    /**
     * Summary of addServiceRequest : ajoute un service à la base de données
     * @param Service $service : service à ajouter à la base de données
     * @return mixed : retourne l'id du service crée, en cas de problème retourne 0
     */
    function addServiceRequest(Service $service){
        try{
            //ajoute les éléments dans la table services
            $name = $service->getName();
            $description = $service->getDescription();
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('insert into services (name, description) VALUES (:name, :description)');
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->execute();

            //recherche l'id du service créé
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

    /**
     * Summary of deleteServiceRequest : supprime un service dans la base de données
     * @param int $id : id du service à supprimer
     * @return void
     */
    function deleteServiceRequest(int $id){
        try{
            if(serviceExistById($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);

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
        }
        catch(error $e){
            echo("problème avec les données");
        }
    }

    /**
     * Summary of updateServiceRequest : met à jour un service dans la base de données
     * @param int $id : l'id du service à mettre à jour
     * @param string $name : nouveau nom (null si pas de changement)
     * @param string $description : nouvelle description (null si pas de changement)
     * @return void
     */
    function updateServiceRequest(int $id, string $name, string $description){
        try{
            //on vérifie que le service existe et qu'il y a une modification à faire
            if(serviceExistById($id) && ($name != null || $description != null)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                //on adapte la requête suivant la/les modifications à effectuer
                //si on modifie l'intitulé et la description
                if(($name != null && $description != null)){
                    $stmt = $pdo->prepare('UPDATE services SET name = :name, description = :description WHERE id_service = :id');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                }
                //si on modifie seulement l'intitulé
                else if($name != null){
                    $stmt = $pdo->prepare('UPDATE services SET name = :name WHERE id_service = :id');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                }
                //si on modifie seulement la description
                else{
                    $stmt = $pdo->prepare('UPDATE services SET description = :description WHERE id_service = :id');
                    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                }
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        catch(error $e){
            echo('erreur bd');
        }
    }
}