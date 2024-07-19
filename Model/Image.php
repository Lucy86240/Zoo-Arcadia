<?php
//namespace image;
class Image{
    private int $id_image;
    private string $path;
    private string $description;
    private bool $icon;
    private bool $portrait;

    /*public function __construct(string $path, string $description, bool $icon, bool $portrait){
        $this->path = $path;
        $this->description = $description;
        $this->icon = $icon;
        $this->portrait = $portrait;
    }*/

    public function getId() : int{
        return $this->id_image;
    }

    public function getPath() : string{
        return $this->path;
    }

    public function setPath(string $path){
        $this->path = $path;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function setIcon(bool $icon){
        $this->icon=$icon;
    }

    public function getPortrait(){
        return $this->portrait;
    }

    public function setPortrait(bool $portrait){
        $this->portrait=$portrait;
    }

    public function getExtension():string{
        $name = explode('.',$this->path);
        return end($name);
    }
}

function searchIdImage(string $type, int $id_type, bool $icon){
    try{
        switch($type){
            case "services" : 
                $table = "images_services";
                $name_id = "id_service";
            case"animals":
                $table = "images_animals";
                $name_id = "id_animal";
            case "housings":
                $table = "images_housings";
                $name_id = "id_housing";
            default :
                $table = "images_services";
                $name_id = "id_service";
        }
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $request = 'SELECT images.id_image FROM '.$table.' JOIN images ON '.$table.'.id_image = images.id_image WHERE '.$table.'.'.$name_id.' = ';
        $stmt = $pdo->prepare($request.' :id_type and images.icon = :icon');
        $stmt->bindParam(":id_type", $id_type, PDO::PARAM_INT);
        $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["id_image"];

    }
    catch(error $e){
        echo("problème avec les données");
        return 0;
    }
}

function imageExistById(int $id){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT id_image FROM images WHERE id_image = :id');
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res != null) return true;
        else return false;
    }
    catch(error $e){
        echo('erreur de bd');
    }
}
function validImg($file){
    $name_file = explode('.',$file['name']);
    $extension = end($name_file);
    $message = null;
    if(!($extension == 'png' || $extension == 'jpg')) $message = "La photo doit être au format jpg ou png. ";
    if($file['size']>5000000){
        if($message != null) $message .= " <br> ";
        $message .= "La taille de la photo ne peut pas être supérieure à 5Mo.";
    } 
    return $message;
}

function validIcon($file){
    $name_file = explode('.',$file['name']);
    $extension = end($name_file);
    $message = null;
    if($extension != 'png') $message = "L'icone doit être au format png. ";
    if($file['size']>100000){
        if($message != null) $message .= " <br> ";
        $message .= "La taille de l'icone ne peut pas être supérieure à 100 ko.";
    } 
    return $message;
}

/**
 * addImgRequest permet d'enregistrer une image dans la base de données
 * @param string $type : 'services' , 'housings', 'animals'
 * @param int $id_type : l'id du service / habitat ou animal concerné
 * @param Image $image : l'image à enregistrer
 * @return void
 */
function addImgRequest(string $type, int $id_type, Image $image){
    try{
        $path = $image->getPath();
        $description = $image->getDescription();
        $icon = $image->getIcon();
        $portrait = $image->getportrait();
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('insert into images (path, description, icon, portrait) VALUES (:path, :description, :icon, :portrait)');
        $stmt->bindParam(":path", $path, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
        $stmt->bindParam(":portrait", $portrait, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT id_image FROM images WHERE path = :path and description = :description');
        $stmt->bindParam(":path", $path, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        switch($type){
            case "services" : 
                $table = "images_services";
                $name_id = "id_service";
            case"animals":
                $table = "images_animals";
                $name_id = "id_animal";
            case "housings":
                $table = "images_housings";
                $name_id = "id_housing";
            default :
                $table = "images_services";
                $name_id = "id_service";
        }

        $request = 'insert into '.$table.' ('.$name_id.', id_image)';
        $stmt = $pdo->prepare($request.' VALUES (:id_type, :id_image)');
        $stmt->bindParam(":id_type", $id_type, PDO::PARAM_INT);
        $stmt->bindParam(":id_image", $res['id_image'], PDO::PARAM_INT);
        $stmt->execute();
    }
    catch(error $e){
        echo("problème avec les données");
    }
}

function updateImageRequest(int $id, string $path, string $description, bool $portrait){

    try{
        if(imageExistById($id)){
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
            $stmt = $pdo->prepare('UPDATE images SET path = :path, description = :description, portrait = :portrait  WHERE id_image = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":path", $path, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":portrait", $portrait, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    catch(error $e)
    {
        echo('erreur bd');
    }

}
