<?php
    include_once "Model/ManageHousingModel.php";
    include_once "Controller/ManageAnimal.php";

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
        $housingsObject = AllHousings($portraitAccept);
        $housings = [];
        $id=0;
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
                $animalsObject = findAnimalsByHousing($housingObject->getId(), $nbAnimals,1, $justVisibleAnimals,$portraitAccept);
                $housing["animals"] =[];
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
                    "date" => date("d/m/Y",strtotime($commentObject->getDate())),
                    "veterinarian" => findNameOfUser($commentObject->getVeterinarian()),
                );
                array_push($housing['comments'],$comment);
            }

            $housings[$id]=$housing;
            $id++;
        }            
    return $housings;
}

function housingArrayAssociation(int $id){
    $housings = allHousingsView(true,-1,-1,1,1);
    $i=0;
    $notfind=true;
    while($notfind && $i<count($housings)){
        if($housings[$i]['id']==$id) $notfind = false;
        else $i++;
    }

    if($notfind==false) $housing = $housings[$i];
    else $housing = [];
    return $housing;
}

function allCommentswithFilter($housing,$dateStart,$dateEnd,$status){
    $commentsObject = allCommentsRequest($housing,$dateStart,$dateEnd,$status);
    $comments=[];
    foreach($commentsObject as $commentObject){
        $comment=array(
            "idComment" => $commentObject->getId(),
            "comment" => $commentObject->getComment(),
            "date" => date("d/m/Y",strtotime($commentObject->getDate())),
            "veterinarian" => findNameOfUser($commentObject->getVeterinarian()),
            "housing" => findHousingNameById($commentObject->getHousing()),
            "archive" => $commentObject->getArchive(),
            );
        array_push($comments,$comment);
    }
    return $comments;
}

function deleteHousing(&$housings){
    foreach($housings as $housing){
        if(isset($_POST['ValidationDeleteHousing'.$housing['id']])){
            // on supprime les animaux de l'habitat (photos et BD)
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
    $housings = allHousingsView(true,-1,-1,1,1);
}

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

        if(isset($_POST['dateStart'])) $dateStart = $_POST['dateStart'];

        if(isset($_POST['dateEnd'])) $dateStart = $_POST['dateEnd'];

        if(isset($_POST['archive']) && isset($_POST['unarchive'])) $status = 2;
        else if(isset($_POST['archive'])) $status = 1;
        else if(isset($_POST['unarchive'])) $status = 0;

        $comments = allCommentswithFilter($housings,$dateStart,$dateEnd,$status);
    }
    else{
        $comments = allCommentswithFilter(null,null,null,null);
    }
}

function deleteComment(&$housings, &$comments){
    $delete = false;
    foreach($comments as $comment){
        if(isset($_POST['ValidationDeleteComment'.$comment['idComment']])){
            deleteCommentRequest($comment['idComment']);
            $delete = true;
        }
    }
    if($delete){
        $housings = allHousingsView(true,-1,-1,1,1);
        filterComments($comments);
    }
}

function addComment(&$housings, &$comments){
    if(isset($_POST['addComment'])){
        if(isset($_POST['addCommentsHousing']) && isset($_POST['addCommentComment'])){
            addCommentRequest($_SESSION['mail'],now(),$_POST['addCommentsHousing'],$_POST['addCommentComment']);
            $housings = allHousingsView(true,-1,-1,1,1);
            filterComments($comments);
        }
    }
}

function changeStatusComment(&$housings, &$comments){
    
    // archivage d'un commentaire
    $archive = false;
    foreach($comments as $comment){
        if(isset($_POST['ValidationArchiveComment'.$comment['idComment']])){
            changeStatusCommentRequest($comment['idComment'],1);
            $archive = true;
        }
    }
    if($archive){
        $housings = allHousingsView(true,-1,-1,1,1);
        filterComments($comments);
    }

    //statut actif d'un commentaire
    $unarchive = false;
    foreach($comments as $comment){
        if(isset($_POST['ValidationUnarchiveComment'.$comment['idComment']])){
            changeStatusCommentRequest($comment['idComment'],0);
            $unarchive = true;
        }
    }
    if($unarchive){
        $housings = allHousingsView(true,-1,-1,1,1);
        filterComments($comments);
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

$housings = allHousingsView(true,-1,-1,1,1);
$comments = allCommentswithFilter(null,null,null,null);
deleteHousing($housings);
addComment($housings,$comments);
filterComments($comments);
deleteComment($housings, $comments);
changeStatusComment($housings, $comments);

