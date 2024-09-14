<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/ManageAnimalModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once "Model/Animal.php";
        require_once "Model/MedicalReport.php";
        require_once "Model/FedAnimal.php";
    
        /**
         * Summary of listAllAnimals retourne la liste de tous les animaux ()
         * @return mixed : tableau associatif
         */
        function listAllAnimals(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT animals.name, breeds.label, animals.id_animal FROM animals JOIN breeds ON animals.breed = breeds.id_breed');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt->execute()){
                    return $stmt->fetchAll();    
                }
                else return [];
            }
            catch(error $e){
                return [];
            }
        }
        /**
         * Summary of listAnimalsWithFilter
         * @param array $breeds : liste des id des races acceptées
         * @param array $housings : liste des id des habitats acceptés
         * @param mixed $isVisible : 0 archivé, 1 visible, autre les 2
         * @param mixed $sort : 'housing' par habitats, 'breed' par races
         * @return array
         */
        function listAnimalsWithFilter(array $breeds, array $housings, $isVisible, $sort, $first, $nbAnimals, &$total){
            try{
                $request='';
                //s'il existe un filtre
                if($breeds!=[] || $housings!=[] || $isVisible==0 || $isVisible==1) $request = 'WHERE ';
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                //ajout à la requ^te le filtre race
                if($breeds != []){
                    $request .= '(animals.breed = '.$breeds[0];
                    if(count($breeds)>1){
                        for($i=1;$i<count($breeds);$i++){
                            $request .= ' OR animals.breed = '.$breeds[$i];
                        }
                    }
                    $request.=')';
                }
                //ajout à la requete le filtre habitat
                if($housings != []){
                    if($request!="WHERE ") $request .= " AND ";
                    $request .= '(animals.housing = '.$housings[0];
                    if(count($housings)>1){
                        for($i=1;$i<count($housings);$i++){
                            $request .= ' OR animals.housing = '.$housings[$i];
                        }
                    }
                    $request .=')';
                }
                //ajout à la requete le statut (archivé/visible)
                if($isVisible==0 || $isVisible==1){
                    if($request!="WHERE ") $request .= " AND ";
                    $request .= '(animals.isVisible = '.$isVisible.')';
                }
    
                //position dans la bd du 1er animal du tableau
                $offset = '';
                if($first != null) $offset=' OFFSET '.$first;
    
                //si un tri est renseigné on initialise une variable
                if($sort=='housing'){
                    $sortRequest="animals.housing";
                }else if($sort=="breed"){
                    $sortRequest = "breeds.label";
                }else{
                    $sortRequest="animals.id_animal DESC";
                }
                //requete preparée en fonction des éléments précédents
                $stmt = $pdo->prepare('SELECT animals.* FROM animals JOIN breeds ON animals.breed = breeds.id_breed '.$request.' ORDER BY '.$sortRequest.' LIMIT :limit '.$offset);
                $stmt->bindParam(':limit',$nbAnimals,PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');
                if($stmt->execute()){
                    $animals= $stmt->fetchAll();
                    //on récupère les photos des animaux   
                    foreach($animals as $animal){
                        $stmt = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id');
                        $id = $animal->getId();
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->setFetchMode(PDO::FETCH_CLASS,'Image');
                        if ($stmt->execute())
                        {
                            while($image = $stmt->fetch()){
                                $animal->addImage($image);
                            }
                        }
                    } 
                    //on met à jour total
                    $stmt = $pdo->prepare('SELECT count(*) FROM animals JOIN breeds ON animals.breed = breeds.id_breed '.$request);
                    $stmt->execute();
                    $total=$stmt->fetch()[0];
    
                    return $animals;
                }
                else return [];
            }
            catch(error $e){
                return [];
            }
        }
    
        /**
         * Summary of countAnimals : indique le nombre d'animal présent dans un habitat
         * @param mixed $justVisibleAnimal : si 0 = animal archivé (non visible par les visiteurs), 1 : visible, 2 : tous
         * @param int $id_housing : identifiant de l'habitat des animaux à compter
         * @return mixed
         */
        function countAnimals($justVisibleAnimal, int $id_housing){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                $visible = "WHERE isVisible = ".$justVisibleAnimal." ";
            }
            else{
                $visible = "";
            }
            $request = 'SELECT count(*) FROM animals '.$visible;
            if($id_housing >0) $request." id_housing = .".$id_housing;
    
            $stmt = $pdo->prepare($request);
    
    
            if($stmt->execute()){
                $res = $stmt->fetch();
                return $res[0];
            }
            else{
                return 0;
            }
        }
    
        /**
             * @param $id_housing 
             * @param $nbAnimals numbers of animals, -1 = all
             * @param $currentPage sert pour la pagination
             * @param $justVisibleAnimal 1: animaux visibles, 0: animaux non visibles, 2: tous
             * @param $portraitAccept si les images en portrait sont acceptées (par défaut true)
             * @return $animals array of animals
             */
            function findAnimalsByHousing(int $id_housing, int $nbAnimals=-1, int $currentPage, int $justVisibleAnimal=1,bool $portraitAccept=true){
                try{
                    $animals = [];
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    //tous les animaux
                    if($nbAnimals<1){
                        //si on souhaite pas voir tous les statuts
                        if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                            $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id and isVisible = :visible');
                            $stmt->bindParam(":visible", $justVisibleAnimal, PDO::PARAM_INT);
                        }
                        else{
                            $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id');
                        }
                    }
                    //nombre limité
                    else{
                            //si on souhaite pas voir tous les statuts
                            if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                                $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id and isVisible = :visible ORDER BY id_animal LIMIT :limit');
                                $stmt->bindParam(":visible", $justVisibleAnimal);                     
                            }
                            else{
                                $stmt = $pdo->prepare('SELECT * FROM animals WHERE housing = :id ORDER BY id_animal LIMIT :limit');
                            }
                            
                            $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);
                    }
    
                    $stmt->bindParam(":id", $id_housing, PDO::PARAM_INT);
                    $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');
    
                    if($stmt->execute()){
                        while($animal = $stmt->fetch()){
                            array_push($animals,$animal);
                            //ajout des images
                            $indice=count($animals)-1;
                            $id = $animals[$indice]->getId();
                            //si les portraits ne sont pas acceptés
                            if($portraitAccept==false){
                                $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                                FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id and images.portrait = 0');
                            }
                            else{
                                $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                                FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id');
                            }
                            $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                            $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                            if ($stmt2->execute())
                            {
                                while($image = $stmt2->fetch()){
                                        $animals[$indice]->addImage($image);
                                }
                            }
                        }
                    }
                    return $animals;
                }
                catch(error $e){
    
                }
        }
    
        /**
         * Summary of AnimalsExtract
         * @param int $justVisibleAnimal : 1 = animaux visible seulement , 0 = animaux invisible (archivé), 2 = tous
         * @param int $nbAnimals : nombre d'animaux retourné / -1 = all
         * @param bool $medicalDetail : false = les rapports médicaux ne sont pas extraits
         * @return array tableau d'objets
         */
        function AnimalsExtract(int $justVisibleAnimal, int $nbAnimals, bool $medicalDetail){
            try{
                $animals = [];
                if($nbAnimals < 0 || $nbAnimals>countAnimals($justVisibleAnimal,-1)) $nbAnimals = countAnimals($justVisibleAnimal,-1);
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                if($justVisibleAnimal==0 || $justVisibleAnimal==1){
                    $stmt = $pdo->prepare('SELECT * FROM animals WHERE isVisible = :visible ORDER BY id_animal ASC LIMIT :limit');
                    $stmt->bindParam(":visible", $justVisibleAnimal, PDO::PARAM_INT);       
                    $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);        
                }
                else{
                    $stmt = $pdo->prepare('SELECT * FROM animals ORDER BY id_animal ASC LIMIT :limit');
                    $stmt->bindParam(":limit", $nbAnimals, PDO::PARAM_INT);
                }      
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
                if($stmt->execute()){
                    while($animal = $stmt->fetch()){
                        $animalObject = new Animal();
                        $animalObject->setId($animal['id_animal']);
                        $animalObject->setName($animal['name']);
                        $animalObject->setIdBreed($animal['breed']);
                        $animalObject->setIdHousing($animal['housing']);
                        $animalObject->setIsVisible($animal['isVisible']);
                        array_push($animals,$animalObject);
                        //add images
                        $indice=count($animals)-1;
                        $id = $animals[$indice]->getId();
                        $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                        FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id');
                        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                        if ($stmt2->execute())
                        {
                            while($image = $stmt2->fetch()){
                                $animals[$indice]->addImage($image);
                            }
                        }
                        if ($medicalDetail==1){
                            $request = 'SELECT * FROM reports_veterinarian WHERE animal = '.$id.' ORDER BY date DESC';
                            $stmt3 = $pdo->prepare($request);
                            $stmt2->setFetchMode(PDO::FETCH_CLASS,'MedicalReport');
                            if ($stmt3->execute())
                            {
                                while($report = $stmt3->fetch()){
                                    $animals[$indice]->addMedicalReport($report);
                                }

                            }
                        }
                
                    }
                }
                return $animals;
            }
            catch(error $e){
                echo('erreur');
                return [];
            }
        }
    
        /**
         * Summary of findAnimalById : trouve l'animal suivant l'id
         * @param int $id : id de l'animal à trouver
         * @return mixed objet animal
         */
        function findAnimalById(int $id){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM animals WHERE id_animal = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');
    
                if($stmt->execute()){
                    $animal = $stmt->fetch();
    
                    //ajout des images
                    $id = $animal->getId();
                    $stmt2 = $pdo->prepare('SELECT images.id_image, images.path, images.description, images.icon, images.portrait 
                    FROM images_animals JOIN images ON images_animals.id_image = images.id_image  WHERE id_animal = :id and images.portrait = 0');
                    $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt2->setFetchMode(PDO::FETCH_CLASS,'Image');
                    if ($stmt2->execute())
                    {
                        while($image = $stmt2->fetch()){
                            $animal->addImage($image);
                        }
                    }
    
                    //ajout des medical reports
                    $stmt3 = $pdo->prepare('SELECT * FROM reports_veterinarian WHERE animal = :id ORDER BY date DESC');
                    $stmt3->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt3->setFetchMode(PDO::FETCH_CLASS,'MedicalReport');
                    if ($stmt3->execute())
                    {
                        while($report = $stmt3->fetch()){
                            $animal->addMedicalReport($report);
                        }
                    }
    
                    //ajouts des foods
    
                    $stmt4 = $pdo->prepare('SELECT * FROM fed_animals WHERE animal = :id ORDER BY date DESC');
                    $stmt4->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt4->setFetchMode(PDO::FETCH_CLASS,'FedAnimal');
                    if ($stmt4->execute())
                    {
                        while($food = $stmt4->fetch()){
                            $animal->addFood($food);
                        }
                    }
    
                    return $animal;
                }
            }
            catch(error $e){
    
            }
        }

                /**
         * Summary of findAnimalById : trouve l'habitat de l'animal
         * @param int $id : id de l'animal à trouver
         * @return mixed 
         */
        function findHousingByIdAnimal(int $id){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT housing FROM animals WHERE id_animal = :id');
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                if($stmt->execute()){
                    return $stmt->fetch()['housing'];
                }
                return 0;
            }
            catch(error $e){
                return 0;
            }
        }
    
        /**
         * Summary of animalExistById : indique si l'animal avec l'id saisi existe
         * @param int $id
         * @return bool
         */
        function animalExistById(int $id){
            $animal = findAnimalById($id);
            if($animal == null) return false;
            else return true;
        }
    
        /**
         * Summary of animalExist : indique si l'objet animal existe dans la base de données
         * @param Animal $animal
         * @return bool
         */
        function animalExist(Animal $animal){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM animals WHERE name = :name and breed = :breed and housing = :housing and isVisible = :visible');
                $name = $animal->getName();
                $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                $breed = $animal->getIdBreed();
                $stmt->bindParam(":breed", $breed, PDO::PARAM_INT);
                $housing = $animal->getIdHousing();
                $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                $visible = $animal->getIsVisible();
                $stmt->bindParam(":visible", $visible, PDO::PARAM_BOOL);
                $stmt->setFetchMode(PDO::FETCH_CLASS,'Animal');
    
                if($stmt->execute()){
                    if ($stmt->fetch() != null) return true;
                    else return false;
                }
                else
                return true;
            }
            catch(error $e){
                return true;
            }
        }
    
        /**
         * Summary of listAllBreeds : retourne la liste de toutes les races de la base de données sous forme de tableau associatif
         * @return array|string
         */
        function listAllBreeds(){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM breeds');
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
         * Summary of breedExist
         * @param string $breed
         * @return int : retourne -1 s'il n'existe pas, -2 en cas de problème de base de données sinon retourne l'id
         *  */
        function breedExistByName(string $breed){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT id_breed FROM breeds WHERE label = :breed');
                $stmt->bindParam(":breed", $breed, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($res == null) return -1;
                else return $res['id_breed'];
            }
            catch(error $e){
                echo('erreur de bd');
                return -2;
            }
        }
    
        /**
         * Summary of breedExistById : indique si la race existe dans la bd
         * @param int $id : id de la race à trouver
         * @return bool
         */
        function breedExistById(int $id){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT * FROM breeds WHERE id_breed = :breed');
                $stmt->bindParam(":breed", $id, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($res == null) return false;
                else return true;
            }
            catch(error $e){
                echo('erreur de bd');
                return true;
            }
        }
    
        /**
         * Summary of addBreedRequest : ajoute une race à la base de donnée
         * @param string $newBreed : nom de la race à ajouter
         * @return int : retourne l'id de la nouvelle race créée
         */
        function addBreedRequest(string $newBreed){
            //vérifie que la race n'existe pas
            if(breedExistByName($newBreed)==-1){
                //on ajoute la race
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('insert into breeds (label) VALUES (:label)');
                $stmt->bindParam(":label", $newBreed, PDO::PARAM_STR);
                $stmt->execute();
                return breedExistByName($newBreed);
            }else{
                return breedExistByName($newBreed);
            }
        }
    
        /**
         * Summary of deleteAnimalRequest : supprime l'animal dans la base de données
         * @param int $id : id de l'animal à supprimer
         * @return void
         */
        function deleteAnimalRequest(int $id){
            try{
                //on vérifie que l'animal existe
                if(animalExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
    
                    //on cherche toutes les images associées à l'animal
                    $stmt = $pdo->prepare('SELECT id_image FROM images_animals WHERE id_animal = :id');
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
    
                    //on supprime l'animal
                    $stmt = $pdo->prepare('DELETE FROM animals WHERE id_animal = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            catch(error $e){
                echo("problème avec la base de données");
            }
        }
    
        /**
         * Summary of addAnimalRequest ajout d'un animal dans la base de données
         * @param Animal $animal : objet animal à ajouter
         * @param mixed $id : id de l'animal crée
         * @return string : message de fin de traitement
         */
        function addAnimalRequest(Animal $animal,&$id){
            try{
                if(!animalExist($animal)){
                    //ajoute les éléments dans la table animal
                    $name = $animal->getName();
                    $breed = $animal->getIdBreed();
                    $housing = $animal->getIdHousing();
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('insert into animals (name, breed, housing) VALUES (:name, :breed, :housing)');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":breed", $breed, PDO::PARAM_INT);
                    $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                    $stmt->execute();
    
                    //recherche l'id de l'animal créé
                    $stmt = $pdo->prepare('SELECT id_animal FROM animals WHERE name = :name and breed = :breed and housing = :housing');
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":breed", $breed, PDO::PARAM_INT);
                    $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                    $stmt->execute();
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $res['id_animal'];
                    return 'success';
                }
                else{
                    return 'error';
                }
            }
            catch(error $e){
                echo("problème avec les données");
                return 'error';
            }
        }
    
        /**
         * Summary of archiveAnimalRequest modification de isVisible en 0 dans la base de données
         * @param int $id : id de l'animal à modifier
         * @return string : message de fin de traitement
         */
        function archiveAnimalRequest(int $id){
            try{
                //on vérifie que l'animal existe
                if(animalExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('UPDATE animals SET isVisible = 0 WHERE id_animal = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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
         * Summary of unarchiveAnimalRequest modification de isVisible en 1 dans la base de données
         * @param int $id : id de l'animal à modifier
         * @return string : message de fin de traitement
         */
        function unarchiveAnimalRequest(int $id){
            try{
                //on vérifie que l'animal existe
                if(animalExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('UPDATE animals SET isVisible = 1 WHERE id_animal = :id');
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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
         * Summary of updateAnimalRequest modification d'un animal dans la base de données
         * @param int $id : id de l'animal à modifier
         * @param string $name : nouveau nom ('' si pas de changement)
         * @param int $housing : nouvel habitat (0 si pas de changement)
         * @param int $breed : nouvelle race
         * @return string : message de fin de traitement
         */
        function updateAnimalRequest(int $id,string $name, int $housing, int $breed){
            try{
                //on vérifie que le service existe et qu'il y a une modification à faire
                if(animalExistById($id)){
                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    //si on modifie le nom
                    if($name != '' ){
                        $stmt = $pdo->prepare('UPDATE animals SET name = :name WHERE id_animal = :id');
                        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    //si on modifie l'habitat
                    if($housing > 0){
                        $stmt = $pdo->prepare('UPDATE animals SET housing = :housing WHERE id_animal = :id');
                        $stmt->bindParam(":housing", $housing, PDO::PARAM_INT);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    //si on modifie la race
                    if(breedExistById($breed)>0){
                        $stmt = $pdo->prepare('UPDATE animals SET breed = :breed WHERE id_animal = :id');
                        $stmt->bindParam(":breed", $breed, PDO::PARAM_INT);
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
         * Summary of idAnimalsOrderByPopularity : tableau par ordre de popularité
         * @return array : tableau d'id d'animaux
         */
        function idAnimalsOrderByPopularity(){
            try{
                    $client = new MongoDB\Client(MONGO_DB_HOST);
                    $popularity = $client->Arcadia->popularity;
                    $filter = [ ];
                    $options = [ 'sort' => [ 'nbClics' => -1 ] ];
                    $list = $popularity->find($filter,$options);
                    $id=[];
                    $request = 'NOT(';
                    foreach($list as $l){
                        $animal = [];
                        $animal['id'] = $l['id_animal'];
                        $animal['clics'] = $l['nbClics'];
                        array_push($id,$animal);
                        if($request!='NOT(') $request .= ' OR ';
                        $request .= " id_animal=".$l['id_animal'];
                    }
                    $request.=')';

                    $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                    $stmt = $pdo->prepare('SELECT id_animal FROM animals WHERE '.$request);
                    if($stmt->execute()){
                        $res = $stmt->fetchAll();
                        foreach($res as $r){
                            $animal = [];
                            $animal['id'] = $r['id_animal'];
                            $animal['clics'] = 0;
                            array_push($id,$animal);
                        }
                    }
                    return $id;
            }
            catch(error $e){
                return [];
            }
        }
    
        /**
         * Summary of animalsOrderByPopularity tableau par ordre de popularité
         * @return array tableau d'objet animaux
         */
        function animalsOrderByPopularity(){
            $popularity = idAnimalsOrderByPopularity();
            $animals = [];
            for($i=0;$i<count($popularity);$i++){
                $animal = findAnimalById($popularity[$i]['id']);
                $animal->setPopularityRange($i+1);
                $animal->setNumberOfClics($popularity[$i]['clics']);
                array_push($animals,$animal);
            }
            return $animals;
        }
    
        /**
         * Summary of animalClic ajoute un clic à un animal (pour la popularité)
         * @param int $id id de l'animal ayant reçu un clic
         * @return string message de fin de traitement
         */
        function animalClic(int $id){
            try{
                //on vérifie que l'animal existe dans la base de données
                if(animalExistById($id)){
                    //on regarde s'il existe dans la base no sql
                    $client = new MongoDB\Client(MONGO_DB_HOST);
                    $popularity = $client->Arcadia->popularity;
                    $exist = $popularity->findOne(['id_animal' => $id]);
                    //s'il n'existe pas on le crée
                    if($exist == null){
                        $animal = findAnimalById($id);
                        $popularity->insertOne([
                            'id_animal' => $id,
                            'Name_breed' => $animal->getName().' - '.$animal->getBreed(),
                            'nbClics' => 1,
                        ]);
                    }else{
                        // s'il existe on le met à jour
                        $clics = $exist["nbClics"]+1;
                        $popularity->updateOne(
                            [ 'id_animal' => $id ],
                            [ '$set' => [ 'nbClics' => $clics]]
                        );
                    }
                }
                    return "success";
                }
            catch(error $e){
                echo('erreur bd');
                return "error";
            }
        }
    }