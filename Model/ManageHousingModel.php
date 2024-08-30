<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/ManageHousingModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    try{
        require_once "Model/Housing.php";
        require_once "Model/Animal.php";
        require_once "Model/ManageAnimalModel.php";
        require_once "Model/Image.php";
        require_once "Model/CommentHousing.php";
        /**
         * Summary of AllHousings : 
         * @param bool $portraitAccept : par défaut vrai, si les images en portrait sont acceptées
         * @return array|Housing tableau de tous les objets habitats de la BD
         */
        function AllHousings(bool $portraitAccept=true){
            try{
                $housings = [];
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM housings');
                $stmt->setFetchMode(PDO::FETCH_CLASS,'Housing');
                if($stmt->execute()){
                    while($housing = $stmt->fetch()){
                        array_push($housings,$housing);
                        $indice=count($housings)-1;
                        $id = $housings[$indice]->getId();
                        //ajout des images
                        if($portraitAccept == false){
                            $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                            FROM images_housings JOIN images ON images_housings.id_image = images.id_image  WHERE id_housing = :id and images.portrait=0');
                        }
                        else{
                            $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                            FROM images_housings JOIN images ON images_housings.id_image = images.id_image  WHERE id_housing = :id');
                        }
                        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                        if ($stmt2->execute())
                        {
                            while($image = $stmt2->fetch()){
                                    $housings[$indice]->addImage($image);
                            }
                        }
                    }
                }
                return $housings;
            }
            catch (error $e){
                echo "Désolée";
                return new Housing();
            }
        }
    
        /**
         * Summary of FindHousingByid  : retourne un objet habitat suivant l'id en paramètre (sans image)
         * @param int $id : id de l'habitat
         * @return array
         */
        function FindHousingByid(int $id){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM housings WHERE id_housing = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $housing = $stmt->fetchAll(PDO::FETCH_CLASS,'Housing');
            return $housing;
        }
    
        /**
         * Summary of housingById: retourne un objet habitat suivant l'id en paramètre (avec image)
         * @param int $id : id de l'habitat
         * @return mixed
         */
        function housingById(int $id){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM housings WHERE id_housing = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Housing');
            $stmt->execute();
            $housing = $stmt->fetchAll();
            if($stmt->execute()){
                $housing = $stmt->fetch();
                $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                FROM images_housings JOIN images ON images_housings.id_image = images.id_image  WHERE id_housing = :id');
                $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                if ($stmt2->execute())
                {
                    while($image = $stmt2->fetch()){
                        $housing->addImage($image);
                    }
                }
            }
            return $housing;
        }
    
        /**
         * Summary of FindHousingByName retourne un tableau asso de l'habitat suivant le nom en paramètre (sans image)
         * @param string $name : nom de l'habitat à trouver
         * @return mixed
         */
        function FindHousingByName(string $name){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM housings WHERE name = :name');
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->execute();
                $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($housing != null) return $housing[0];
                else null;
            }
            catch(Error $e){
                echo "Erreur de base de données";
                return null;
            }
        }
    
        /**
         * Summary of findHousingNameById indique le nom d'un habitat suivant son id
         * @param int $id : id de l'habitat
         * @return mixed
         */
        function findHousingNameById(int $id){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT name FROM housings WHERE id_housing = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                if($stmt->execute()){
                    $housing = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $housing[0]['name'];
                }
                else return '';
            }
            catch(Error $e){
                echo "Désolée";
                return '';
            }
        }
    
        /**
         * Summary of listNameIdAllHousings : tableau avec tous les habitats de la base de données
         * @return array|string tableau asso (name, id_housing)
         */
        function listNameIdAllHousings(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT name, id_housing FROM housings');
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }
            catch(Error $e){
                echo "Désolée";
                return '';
            }
        }
    
        /**
         * Summary of listIdAllHousings tableau avec tous les habitats de la base de données
         * @return array|string tableau d'id
         */
        function listIdAllHousings(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT id_housing FROM housings');
                $stmt->execute();
    
                $temp = $stmt->fetchAll(PDO::FETCH_NUM);
                $res=[];
                for($i=0;$i<count($temp);$i++){
                    array_push($res,$temp[$i][0]);
                }
                return $res;
            }
            catch(Error $e){
                echo "Erreur de base de données";
                return '';
            }
        }
    
        /**
         * Summary of housingExist indique si l'objet existe dans la base de données
         * @param Housing $housing : objet housing à trouver
         * @return bool
         */
        function housingExist(Housing $housing){
            $name = $housing->getName();
            if (FindHousingByName($name) != null) return true;
            else return false;
        }
    
        /**
         * Summary of housingExistById indique si l'id existe dans la base de données
         * @param int $id : id d'un habitat à trouver
         * @return bool
         */
        function housingExistById(int $id){
            if (FindHousingById($id) != null) return true;
            else return false;
        }
    
        /**
         * Summary of addHousingRequest ajoute un habitat à la base de données
         * @param Housing $housing : objet à ajouter à la BD
         * @param mixed $id : id de l'habitat crée
         * @return string : message de fin de traitement
         */
        function addHousingRequest(Housing $housing,&$id){
            try{
                // on vérifie d'abord que l'habitat n'existe pas
                if(housingExist($housing)==false){
                    //ajoute les éléments dans la table housing
                    $name = $housing->getName();
                    $description = $housing->getDescription();
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('insert into housings (name, description) VALUES (:name, :description)');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                    $stmt->execute();
        
                    //recherche l'id de l'habitat créé
                    $stmt = $pdo->prepare('SELECT id_housing FROM housings WHERE name = :name and description = :description');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                    $stmt->execute();
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $res['id_housing'];
                    return 'success';
                }
                else{
                    return 'error';
                }
            }
            catch(error $e){
                echo("problème avec la base de données");
                return 'error';
            }
        }
    
        /**
         * Summary of updateHousingRequest met à jour un habitat de la base de données
         * @param int $id : id de l'habitat à mettre à jour
         * @param mixed $name : nouveau nom (0 si pas de modification)
         * @param mixed $description : nouvelle description (0 si pas de modification)
         * @return string : message de fin de traitement
         */
        function updateHousingRequest(int $id,$name,$description){
            try{
                //on vérifie que l'habitat existe et qu'il y a une modification à faire
                if(housingExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    if($name != '0' ){
                        $stmt = $pdo->prepare('UPDATE housings SET name = :name WHERE id_housing = :id');
                        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
        
                    if($description != '0'){
                        $stmt = $pdo->prepare('UPDATE housings SET description = :description WHERE id_housing = :id');
                        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
                return "success";
            }
            catch(error $e){
                echo('erreur bd');
                return "error";
            }
        }
    
        /**
         * Summary of deleteHousingRequest suppression d'un habitat dans la base de données
         * @param mixed $id : id de l'habitat à supprimer
         * @return void
         */
        function deleteHousingRequest($id){
            try{
                //on vérifie que l'habitat existe
                if(housingExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
    
                    //on cherche toutes les images associées à l'habitat
                    $stmt = $pdo->prepare('SELECT id_image FROM images_housings WHERE id_housing = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    //on supprime toutes les images
                    if($res != null){
                        foreach ($res as $id_image){
                            $stmt = $pdo->prepare('DELETE FROM images WHERE id_image = :id');
                            $stmt->bindParam(":id", $id_image['id_image'], PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    }
        
                    //on supprime l'habitat
                    $stmt = $pdo->prepare('DELETE FROM housings WHERE id_housing = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            catch(error $e){
                echo("problème avec les données");
            }
        }
    
        /**
         * Summary of commentHousing tableau de commentaires en fonction de filtres
         * @param int $housing : id de l'habitat des commentaires souhaités
         * @param mixed $archive : 1 archivé, 0 actif, 2 les deux
         * @return array|string : tableau d'objets CommentHousing
         */
        function commentHousing(int $housing,$archive){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $request='';
                
                if($archive==1 || $archive==0){
                    $request=' AND archive='.$archive;
                }
                $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto WHERE housing= :housing'.$request);
                $stmt->bindParam(':housing',$housing,PDO::PARAM_INT);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_CLASS,'CommentHousing');
                return $res;
            }
            catch(Error $e){
                echo "Désolée";
                return '';
            }
        }
    
        /**
         * Summary of allCommentsRequest
         * @param mixed $housing peut être null sinon tableau d'id
         * @param mixed $dateStart peut être null
         * @param mixed $dateEnd peut être null
         * @param mixed $status : 1 = archivé 0 = actif 2 = tous
         * @return array
         */
        function allCommentsRequest($housing,$dateStart,$dateEnd,$status){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $request='';
                if($housing != null || $dateEnd !=null || $dateStart != null || $status != null){
                    $request="WHERE";
                    if($housing !=null){
                        $request.=' housing='.$housing[0];
                        for ($i=1; $i < count($housing); $i++){
                            $request.=' OR housing='.$housing[$i];
                        }
                    }
                    if(($status==1 || $status==0) && $status != null){
                        if($request != "WHERE") $request.= " AND";
                        $request.=' archive='.$status;
                    }
                    if($dateStart != null){
                        if($request != "WHERE") $request.= " AND";
                        $request.=' date >= \"'.$dateStart."\"";
                    }
                    if($dateEnd != null){
                        if($request != "WHERE") $request.= " AND";
                        $request.=' date >= \"'.$dateEnd."\"";
                    }
                }
                $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto '.$request.' ORDER BY date DESC');
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_CLASS,'CommentHousing');
                return $res;
            }
            catch(Error $e){
                echo "Désolée";
                return [];
            }
        }
    
        /**
         * Summary of commentExist indique si un commentaire existe en fonction des éléments renseignés
         * @param mixed $veto : id du veto
         * @param mixed $date : date du com
         * @param mixed $housing : id de l'habitat
         * @param mixed $comment : commentaire
         * @return bool : attention retourne vrai en cas de problème de BD
         */
        function commentExist($veto, $date, $housing, $comment){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto 
                WHERE comment = :comment AND housing = :housing AND veterinarian = :veterinarian AND date=:date');
                $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
                $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
                $stmt->bindParam(":date", $date, PDO::PARAM_STR);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt->execute()){
                    if($stmt->fetch() == null) return false;
                    else return true;
                }
                else return true;
            }
            catch(error $e){
                return true;
            }
        }
    
        /**
         * Summary of commentExistbyId indique si un commentaire existe en fonction de l'id
         * @param mixed $id
         * @return bool
         */
        function commentExistbyId($id){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM comments_housing_veto 
                WHERE id_comment = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt->execute()){
                    if($stmt->fetch() == null) return false;
                else return true;
                }
                else return true;
            }
            catch(error $e){
                return true;
            }
        }
    
        /**
         * Summary of changeStatusCommentRequest : permet d'archiver ou rendre actif un commentaire
         * @param int $id : identifiant du commentaire
         * @param bool $status : 1 pour archivé, 0 pour actif
         * @return string : success ou error
         */
        function changeStatusCommentRequest(int $id,bool $status){
            try{
                //on vérifie que le service existe et qu'il y a une modification à faire
                if(commentExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('UPDATE comments_housing_veto SET archive = :status WHERE id_comment = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->bindParam(":status", $status, PDO::PARAM_BOOL);
                    $stmt->execute();
                }
                return "success";
            }
            catch(error $e){
                echo('erreur bd');
                return "error";
            }
        }
    
        /**
         * Summary of addCommentRequest : ajoute un commentaire à la base de données
         * @param mixed $veto : id véto
         * @param mixed $date : date du commentaire
         * @param mixed $housing : id de l'habitat
         * @param mixed $comment : commentaire
         * @return void
         */
        function addCommentRequest($veto, $date, $housing, $comment){
            try{
                //on vérifie d'abord que le commentaire n'existe pas
                if(commentExist($veto, $date, $housing, $comment)==false){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('insert into comments_housing_veto (veterinarian,housing,comment,date) 
                    VALUES (:veterinarian,:housing,:comment,:date)');
                    $stmt->bindParam(":veterinarian", $veto, PDO::PARAM_STR);
                    $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                    $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
                    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
            catch(error $e)
            {
                echo("Erreur de base de données");
            }
        }
    
        /**
         * Summary of deleteCommentRequest supprime un commentaire de la base de données
         * @param int $id : id du commentaire à supprimer
         * @return void
         */
        function deleteCommentRequest(int $id){
            try{
                if(commentExistById($id)==true){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('DELETE FROM comments_housing_veto WHERE id_comment = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            catch(error $e)
            {
                echo("Erreur de base de données");
            }
        }
    
        /**
         * Summary of housingsIDOrderByPopularity : tableau des id et clics des habitats en fonction de leur popularité
         * @return array
         */
        function housingsIDOrderByPopularity(){
            try{
                $popularityHousing = [];
                $popularityAnimals = idAnimalsOrderByPopularity();
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                //requete du nombre de clics par housing
                $stmt = $pdo->prepare('SELECT id_housing FROM housings');
                $stmt->setFetchMode(PDO::FETCH_NUM);

                if($stmt->execute()){
                    $res=$stmt->fetchAll();

                    for($i=0;$i<count($res);$i++){
                        $housing=[];
                        $housing['id_housing'] = $res[$i][0];
                        $housing['clics'] =0;
                        $housing['order'] = false;
                        array_push($popularityHousing,$housing);
                    }

                    for($i=0; $i<count($popularityAnimals); $i++){
                        $id= findHousingByIdAnimal($popularityAnimals[$i]['id']);
                        $housing = false;
                        $j=0;
                        while($housing == false && $j<count($popularityHousing)){
                            
                            if($id == $popularityHousing[$j]['id_housing']){
                                $housing = true;
                            }
                            else $j++; 
                        }
                        if($housing) $popularityHousing[$j]['clics']+=$popularityAnimals[$i]['clics'];
                    }
                    $clics = [];
                    for($i=0;$i<count($popularityHousing);$i++){
                        array_push($clics,$popularityHousing[$i]['clics']);
                    }
                    rsort($clics);
                    $popularityOrder=[];
                    for($i=0;$i<count($clics);$i++){
                        $find = false;
                        $j=0;
                        while(!$find &&$j<count($clics)){
                            if($popularityHousing[$j]['clics']==$clics[$i] && $popularityHousing[$j]['order']==false){
                                $find = true;
                            }
                            else $j++;
                        }
                        if($find){
                            $popularityHousing[$j]['order'] = true;
                            array_push($popularityOrder,$popularityHousing[$j]);
                        }
                    }
                    return $popularityOrder;
                }
                else return [];
            }
            catch(error $e){
                return [];
            }
        }
    
        /**
         * Summary of housingsOrderByPopularity tableau d'habitat en fonction de leur popularité
         * @return array
         */
        function housingsOrderByPopularity(){
            $idHousings = housingsIDOrderByPopularity();
            $housings = [];
            for($i=0;$i<count($idHousings);$i++){
                $housing=housingById($idHousings[$i]['id_housing']);
                $housing->setPopularityRange($i+1);
                $housing->setNumberOfClics($idHousings[$i]['clics']);
                array_push($housings,$housing);
            }
            return $housings;
        }
    }
    catch(error $e){
        echo('oups une ou plusieurs classes ont disparu...');
    }

}