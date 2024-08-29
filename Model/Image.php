<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/Image.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    //namespace image;
    class Image{
        private int $id_image;
        private string $path;
        private string $description;
        private bool $icon;
        private bool $portrait;

        private string $attribution;

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

        
        public function getAttribution(){
            if(!isset($this->attribution))
                return '';
            else
                return $this->attribution;
        }

        public function setAttribution(string $attribution){
            $this->attribution = $attribution;
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

    /**
     * Summary of searchIdImage : retourne l'id de la 1ere image
     * @param string $type : services, housings, animals
     * @param int $id_type : id du type
     * @param bool $icon : si c'est une icone
     * @return mixed : id de l'image
     */
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
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
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

    /**
     * Summary of searchPathById récupère le chemin d'une image via son id
     * @param int $id id de l'image
     * @return mixed path
     */
    function searchPathById(int $id){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT path FROM images WHERE id_image = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch()["path"];

        }
        catch(error $e){
            echo("problème avec les données");
            return 0;
        }
    }

    /**
     * Summary of imageExistById : indique si une image existe en fonction d'un id
     * @param int $id : id d'une image
     * @return bool
     */
    function imageExistById(int $id){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT id_image FROM images WHERE id_image = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res != null) return true;
            else return false;
        }
        catch(error $e){
            echo('erreur de bd');
            return true;
        }
    }

    /**
     * Summary of validImg indique si l'image est valide (extention, taille)
     * @param mixed $file : tableau asso du type $_FILE
     * @return string|null : null ou message d'erreur
     */
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

    /**
     * Summary of validIcon indique si l'icone est valide (extention, taille)
     * @param mixed $file : tableau asso du type $_FILE
     * @return string|null : null ou message d'erreur
     */
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
     * Summary of listAttributions : retourne la liste des attributions
     * @return array
     */
    function listAttributions(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare("SELECT attribution FROM images  WHERE attribution != ''");
            if($stmt->execute()){
                $temp = $stmt->fetchAll();
                $res = [];
                foreach($temp as $t){
                    array_push($res,$t[0]);
                }
                
                return $res;
            }
            return [];
        }
        catch(error $e)
        {
            echo('erreur bd');
            return [];
        }
    }

    /**
     * addImgRequest permet d'enregistrer une image dans la base de données
     * @param string $type : 'services' , 'housings', 'animals'
     * @param int $id_type : l'id du service / habitat ou animal concerné
     * @param Image $image : l'image à enregistrer
     * @return string : success ou error
     */
    function addImgRequest(string $type, int $id_type, Image $image){
        try{
            $path = $image->getPath();
            $description = $image->getDescription();
            $icon = $image->getIcon();
            $portrait = $image->getportrait();
            $attribution = $image->getAttribution();
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('insert into images (path, description, icon, portrait,attribution) VALUES (:path, :description, :icon, :portrait, :attribution)');
            $stmt->bindParam(":path", $path, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
            $stmt->bindParam(":portrait", $portrait, PDO::PARAM_STR);
            $stmt->bindParam(":attribution", $attribution, PDO::PARAM_STR);
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
                    break;
                case"animals":
                    $table = "images_animals";
                    $name_id = "id_animal";
                    break;
                case "housings":
                    $table = "images_housings";
                    $name_id = "id_housing";
                    break;
                default :
                    $table = "images_services";
                    $name_id = "id_service";
                    break;
            }

            $request = 'insert into '.$table.' ('.$name_id.', id_image)';
            $stmt = $pdo->prepare($request.' VALUES (:id_type, :id_image)');
            $stmt->bindParam(":id_type", $id_type, PDO::PARAM_INT);
            $stmt->bindParam(":id_image", $res['id_image'], PDO::PARAM_INT);
            $stmt->execute();
            return "success";
        }
        catch(error $e){
            echo("problème avec les données");
            return "error";
        }
    }

    /**
     * Summary of updateImageRequest met à jour une image de la BD
     * @param int $id : id de l'image
     * @param string $path : nouveau chemin (ne doit pas être vide)
     * @param string $description : nouvelle description
     * @param bool $portrait : true/false
     * @param string $attr : attributions
     * @return void
     */
    function updateImageRequest(int $id, string $path, string $description, bool $portrait, string $attr){

        try{
            if(imageExistById($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('UPDATE images SET path = :path, description = :description, portrait = :portrait, attribution= :attr  WHERE id_image = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":path", $path, PDO::PARAM_STR);
                $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                $stmt->bindParam(":portrait", $portrait, PDO::PARAM_STR);
                $stmt->bindParam(":attr", $attr, PDO::PARAM_STR);

                $stmt->execute();
            }
        }
        catch(error $e)
        {
            echo('erreur bd');
        }

    }

    /**
     * Summary of deleteImageRequest supprime l'image de la base de données
     * @param int $id : id de l'image à supprimer
     * @return void
     */
    function deleteImageRequest(int $id){
        try{
            if(imageExistById($id)){
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('DELETE FROM images WHERE id_image = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        catch(error $e)
        {
            echo('erreur bd');
        }
    }
}