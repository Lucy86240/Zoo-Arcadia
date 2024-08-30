<?php
//execution du programme seulement si l'url actuel est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageHousing.php'){
    try{
        require_once "Model/ManageHousingModel.php";
        require_once "Controller/ManageAnimal.php";
    
        /**
         * Retourne un tableau associatif avec au moins tout les noms des habitats
         * @param $id true ajoute l'id au tableau
         * @param $description true ajoute la description au tableau
         * @param $nbImgs ajoute les chemins, descriptions du nombre d'image indiquées
         * @param $nbAnimals ajoute les éléments d'autant d'animal que souhaité (-1 = all)
         * @param $justVisibleAnimals 1: animaux visibles, 0: animaux non visibles, 2: tous
         * @param $portraitAccept si les images en portrait sont acceptées (par défaut true)
         */
        function allHousingsView(bool $description=true, int $nbImgs=-1, int $nbAnimals=0, int $justVisibleAnimals=1, bool $portraitAccept=true){
            // on récupère tous les objets habitats de la base de données
            $housingsObject = AllHousings($portraitAccept);
            $housings = [];
            $id=0;
            //on crée le talbeau associatifs
            foreach($housingsObject as $housingObject){ 
                $housing = array(
                    "name" => $housingObject->getName(),
                    "id" => $housingObject->getId(),
                );
                if($description == true){
                    $housing["description"] = $housingObject->getDescription();
                }
    
                //ajout du nombre d'images souhaitées
                if ($nbImgs == -1 || $nbImgs > $housingObject->countImages() ){
                    $nb = $housingObject->countImages();
                }
                else{
                    $nb = $nbImgs;
                }
                $housing['images'] = [];
                for($i=0 ; $i<$nb; $i++){
                    $img= array(
                            'path' => $housingObject->getImage($i)->getPath(),
                            'description' => $housingObject->getImage($i)->getDescription(),
                            'id' => $housingObject->getImage($i)->getId(),
                        );
                        array_push($housing['images'],$img);
                    }
                    //si pas d'image on ajoute celle par défaut
                    if($housing['images'] == []){
                        $img= array(
                            'path' => IMG_DEFAULT_HOUSING,
                            'description' => "photo indisponible",
                            'id' => 0,
                        );
                        array_push($housing['images'],$img);
                    }
                    
    
                    //ajout du nombre d'animaux souhaités
                    if ($nbAnimals != 0)
                    {
                        //on récupère les objets animaux souhaités
                        $animalsObject = findAnimalsByHousing($housingObject->getId(), $nbAnimals,1, $justVisibleAnimals,$portraitAccept);
                        $housing["animals"] =[];
                        //on crée un tableau asso d'animal
                        foreach($animalsObject as $animalObject){
                            $animal = array(
                                "id" => $animalObject->getId(),
                                "name" => $animalObject->getName(),
                                "breed" => $animalObject->getBreed(),
                                "IsVisible" => $animalObject->getIsVisible(),
                            );
                            $animal['imagesAnimals'] = [];
                            for($i=0 ; $i<$animalObject->countImages(); $i++){
                                $img= array(
                                    "pathAnimals" => $animalObject->getImage($i)->getPath(),
                                    "descriptionAnimals" => $animalObject->getImage($i)->getDescription(),
                                );
                                array_push($animal['imagesAnimals'],$img);
                            }
                            if($animal['imagesAnimals']==[]){
                                $img= array(
                                    "pathAnimals" => IMG_DEFAULT_ANIMAL,
                                    "descriptionAnimals" => 'pas de photo disponible',
                                );
                                array_push($animal['imagesAnimals'],$img);
                            }
                            array_push($housing["animals"],$animal);
                        }
                    }
    
                    //ajout des commentaires
                    $commentsObject = commentHousing($housing['id'],0);
                    $housing['comments']=[];
                    foreach($commentsObject as $commentObject){
                        $comment=array(
                            "idComment" => $commentObject->getId(),
                            "comment" => $commentObject->getComment(),
                            "date" => date("d/m/Y",strtotime($commentObject->getDate())), // on affiche la date de manière traditionnelle
                            "veterinarian" => findNameOfUser($commentObject->getVeterinarian()), // onr récupère le nom prénom du véto
                        );
                        array_push($housing['comments'],$comment);
                    }
    
                    $housings[$id]=$housing;
                    $id++;
                }            
            return $housings;
        }
    
        /**
         * Summary of housingArrayAssociation : permet d'avoir un tableau associatif d'un habitat particulier
         * @param int $id : id de l'habitat
         * @return array : tableau associatif de l'habitat souhaité
         */
        function housingArrayAssociation(int $id){
            //on récupère les habitats
            $housings = allHousingsView(true,-1,-1,1,1);
            //on cherche celui souhaité
            $i=0;
            $notfind=true;
            while($notfind && $i<count($housings)){
                if($housings[$i]['id']==$id) $notfind = false;
                else $i++;
            }
            //on retourne celui trouvé
            if($notfind==false) $housing = $housings[$i];
            else $housing = [];
            return $housing;
        }
    
        /**
         * Summary of allCommentswithFilter : retourne un tableau de commentaire en fonction de filtres
         * @param mixed $housing : tableau d'id d'habitats
         * @param mixed $dateStart : date de début
         * @param mixed $dateEnd : date de fin
         * @param mixed $status : 0: visible, 1: archive, 2 : tous
         * @return array : tableau asso (idComment,comment,date,veterinarian(nom prénom),housing(nom),archive(0/1))
         */
        function allCommentswithFilter($housing,$dateStart,$dateEnd,$status){
            //on récupère les objets commentaires de la base de données
            $commentsObject = allCommentsRequest($housing,$dateStart,$dateEnd,$status);
            //on crée le tableau associatif
            $comments=[];
            foreach($commentsObject as $commentObject){
                $comment=array(
                    "idComment" => $commentObject->getId(),
                    "comment" => $commentObject->getComment(),
                    "date" => date("d/m/Y",strtotime($commentObject->getDate())), //date de manière traditionnelle
                    "veterinarian" => findNameOfUser($commentObject->getVeterinarian()), //nom prénom du véto
                    "housing" => findHousingNameById($commentObject->getHousing()), //nom de l'habitat
                    "archive" => $commentObject->getArchive(),
                    );
                array_push($comments,$comment);
            }
            return $comments;
        }
    
        /**
         * Summary of deleteHousing : permet de supprimer un habitat en fonction d'une popup de confirmation
         * @param mixed $housings : tableau des habitats à mettre à jour
         * @return void
         */
        function deleteHousing(&$housings){
            foreach($housings as $housing){
                if(isset($_POST['ValidationDeleteHousing'.$housing['id']])){
                    // on supprime les animaux de l'habitat (BD et photos)
                    $animals = findAnimalsByHousing($housing['id'],-1,0,2,1);
                    foreach($animals as $animal){
                        deleteAnimalWithoutForm($animal);
                    }
                    //on supprime les photos 
                    $path = "View/assets/img/housings/".$housing['id'];
                    rrmdir($path);
    
                    //on supprime l'habitat de la BD 
                    deleteHousingRequest($housing['id']);
                }
            }
            //on met à jour le tableau des habitats
            $housings = allHousingsView(true,-1,-1,1,1);
        }
    
        /**
         * Summary of filterComments permet de mettre à jour le tableau de commentaires en fonction des $_POST
         * @param mixed $comments : tableau à mettre à jour
         * @return void
         */
        function filterComments(&$comments){
            if(isset($_POST['filter'])){
                
                $dateStart=null;
                $dateEnd=null;
                $status=null;
                
                $lenght = count(listNameIdAllHousings());
                $housings = [];
                for($i=0;$i<$lenght;$i++){
                    if(isset($_POST['housing'.$i])) array_push($housings,$_POST['housing'.$i]);
                }
                if($housings==[]) $housings=null;
    
                if(isset($_POST['dateStart']) && isDate($_POST['dateStart'])) $dateStart = $_POST['dateStart'];
    
                if(isset($_POST['dateEnd']) && isDate($_POST['dateEnd'])) $dateStart = $_POST['dateEnd'];
    
                if(isset($_POST['archive']) && isset($_POST['unarchive'])) $status = 2;
                else if(isset($_POST['archive'])) $status = 1;
                else if(isset($_POST['unarchive'])) $status = 0;
    
                $comments = allCommentswithFilter($housings,$dateStart,$dateEnd,$status);
            }
            else{
                $comments = allCommentswithFilter(null,null,null,null);
            }
        }
    
        /**
         * Summary of deleteComment permet de supprimer un commentaire (en fonction d'une popup de validation)
         * @param mixed $housings : tableau des habitats à mettre à jour (null si pas nécessaire)
         * @param mixed $comments : tableau des commentaires à mettre à jour (null si pas nécessaire)
         * @return void
         */
        function deleteComment(&$housings, &$comments){
            $delete = false;
            //vérifie si on a cliqué sur un oui d'une popup de suppression
            foreach($comments as $comment){
                if(isset($_POST['ValidationDeleteComment'.$comment['idComment']])){
                    //on supprime de la base de données
                    deleteCommentRequest($comment['idComment']);
                    $delete = true;
                }
            }
            //si on a fait une suppression on met à jour les tableaux
            if($delete){
                if($housings!=null) $housings = allHousingsView(true,-1,-1,1,1);
                else filterComments($comments);
            }
        }
    
        /**
         * Summary of addComment permet d'ajoute un commentaire (formulaire nécessaire)
         * @param mixed $housings : tableau d'habitats à mettre à jour (null si pas nécessaire)
         * @param mixed $comments : tableau de commentaires à mettre à jour (null si pas nécessaire)
         * @return void
         */
        function addComment(&$housings, &$comments){
            //si on a validé le formulaire
            if(isset($_POST['addComment'])){
                //si les infos sont bien renseignées
                if(isset($_POST['addCommentsHousing']) && isset($_POST['addCommentComment']) && isText($_POST['addCommentComment'])){
                    //ajout à la base de données
                    addCommentRequest($_SESSION['mail'],now(),$_POST['addCommentsHousing'],$_POST['addCommentComment']);
                    //mise à jour des tableaux
                    if($housings != null) $housings = allHousingsView(true,-1,-1,1,1);
                    else filterComments($comments);
                }
            }
        }
    
        /**
         * Summary of changeStatusComment : permet d'archiver/désarchiver un commentaire (nécessite un formulaire)
         * @param mixed $housings : tableau des habitats à mettre à jour (null si pas nécessaire)
         * @param mixed $comments : tableau des commentaires à mettre à jour (null si pas nécessaire)
         * @return void
         */
        function changeStatusComment(&$housings, &$comments){
            
            // archivage d'un commentaire
            $archive = false;
            //on vérifie si un oui a été cliqué sur une popup
            foreach($comments as $comment){
                if(isset($_POST['ValidationArchiveComment'.$comment['idComment']])){
                    //changement dans la base de données
                    changeStatusCommentRequest($comment['idComment'],1);
                    $archive = true;
                }
            }
    
            //statut actif d'un commentaire
            $unarchive = false;
            //on vérifie si un oui a été cliqué sur une popup
            foreach($comments as $comment){
                if(isset($_POST['ValidationUnarchiveComment'.$comment['idComment']])){
                    //changement dans la base de données
                    changeStatusCommentRequest($comment['idComment'],0);
                    $unarchive = true;
                }
            }
    
            //on modifie les tableaux
            if($unarchive || $archive){
                if($housings != null) $housings = allHousingsView(true,-1,-1,1,1);
                else filterComments($comments);
            }
        }
    
        function defaultValueCheckbox(string $checkbox){
            if(isset($_POST['filter']) && isset($_POST[$checkbox])) return 'checked';
            if(!isset($_POST['filter'])) return 'checked';
            return '';
        }
    
        function defaultValueDate(string $date){
            if(isset($_POST['filter']) && isset($_POST[$date])) return $_POST[$date];
            return '';
        }
    
        //si on est sur la page des commentaires vétérinaires
        if($_SERVER['REQUEST_URI']=='/commentaires_habitats'){
            //on récupère les données
            $comments = allCommentswithFilter(null,null,null,null);
            $housings = null;
            //on permet la mise à jour des données
            addComment($housings,$comments);
            filterComments($comments);
            deleteComment($housings, $comments);
            changeStatusComment($housings, $comments);
        }
        else{
            //on récupère les données
            $housings = allHousingsView(true,-1,-1,1,1);
            $comments = allCommentswithFilter(null,null,null,null);
            // on permet la mise à jour des données
            deleteHousing($housings);
            addComment($housings,$comments);
            deleteComment($housings, $comments);
            changeStatusComment($housings, $comments);
        }
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    //on affiche page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
