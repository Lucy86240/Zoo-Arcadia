<?php

//include_once "../../Model/Review.php";
//include_once "../../Model/User.php";

include_once "Model/Review.php";
include_once "Model/User.php";

/**
 * @Param $nbReviews nombre d'avis retournés souhaités
 * @Param $startList premier avis à retourner
 * @Param $endList dernier avis à retourner
 * @Param $orderBy : "idC" = id_review croissants, "idD" = id_review decroissants, 
 * "DvC" = dates de visite croissants, "DvD" = dates de visite décroissants, 
 * "NC" = notes croissantes, "ND" = notes décroissantes
 * @Param $JustVisible true = ne retourne que des avis acceptés
 * @Param $showDateCheck : false = l'avis n'inclus pas la date d'acceptation
 * @Param $showCheckBy : false = l'avis n'inclus pas l'employé qui l'a validé
 */
//function ReviewsExtract(int $nbReviews,int $startList, int $endList, string $orderBy="DvD", bool $JustVisible=true, bool $showDateCheck=false, bool $showCheckBy=false)


/**
 * @Param $nbReviews nombre d'avis retournés souhaités
 * @Param $startList premier avis à retourner
 * @Param $orderBy : "idC" = id_review croissants, "idD" = id_review decroissants, 
 * "DvC" = dates de visite croissants, "DvD" = dates de visite décroissants, 
 * "NC" = notes croissantes, "ND" = notes décroissantes
 * @Param $JustVisible true = ne retourne que des avis acceptés
 * @Param $showDateCheck : false = l'avis n'inclus pas la date d'acceptation
 * @Param $showCheckBy : false = l'avis n'inclus pas l'employé qui l'a validé
 */
function reviewsExtract(int $nbReviews,int $startList=0, string $orderBy, bool $JustVisible=true,string $filter){
    switch ($orderBy){
        case "idC": 
            $order="id_review ASC";
            break;
        case "idD":
            $order="id_review DESC";
            break;
        case "DvC":
            $order="date_visite ASC";
            break;
        case "NC":
            $order="note ASC";
            break;
        case "ND":
            $order="note ASC";
            break;

        default:
            $order="date_visite DESC";
            break;
    }
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
    if($nbReviews<1 && $JustVisible==false){
        $stmt = $pdo->prepare('SELECT * FROM reviews');
        echo("1");
    }
    else if($JustVisible){
        $request = 'SELECT * FROM reviews WHERE isVisible=1 ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
        $stmt = $pdo->prepare($request);
    }
    else{
        if($filter !=""){
            $request = 'SELECT * FROM reviews WHERE '.$filter.' ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
            $stmt = $pdo->prepare($request);
        }
        else{
            $request = 'SELECT * FROM reviews ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
            $stmt = $pdo->prepare($request);
        }
    }
    $stmt->setFetchMode(PDO::FETCH_CLASS,'Review');
    if($stmt->execute()){
        return $stmt->fetchAll();
    }
    else{
        return new Review();
    }
}

function countReviews(int $isVisible=2, int $check=2){
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
    if(($isVisible!=0 && $isVisible!=1) && ($check!=0 && $check!=1)){
        $stmt = $pdo->prepare('SELECT count(*) FROM reviews');
    }
    else if($isVisible ==1){
        $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=1 ');
    }
    else{
        if($check==1){
            $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=0 and check_by is not null');
        }
        else{
            $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=0 and date_check is null');
        }
        
    }

    if($stmt->execute()){
        $res = $stmt->fetch();
        return $res[0];
    }
    else{
        return 0;
    }
}

function countReviewsFilter(string $filter){
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
    if($filter==""){
        $stmt = $pdo->prepare('SELECT count(*) FROM reviews');
    }
    else {
        $request = 'SELECT count(*) FROM reviews WHERE '.$filter;
        $stmt = $pdo->prepare($request);
    }

    if($stmt->execute()){
        $res = $stmt->fetch();
        return $res[0];
    }
    else{
        return 0;
    }
}

function avgReviewsVisible(){
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
    $stmt = $pdo->prepare('SELECT round(avg(note),2) FROM reviews WHERE isVisible = 1');
    if($stmt->execute()){
        $res = $stmt->fetch();
        return $res[0];
    }
    else{
        return "oups les calculs sont pas bons";
    }
}

function porcentNote(int $note){

    if($note<0 || $note>5){
        echo("improbable");
        return 0;
    }
    else{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE note=:note and isVisible=1');
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        if($stmt->execute()){
            $res = $stmt->fetch();
            $r= $res[0]/countReviews(1,1)*100;
            return $r;
        }
        else{
            return "oups les calculs sont pas bons";
        }
    }
}

/**Permet de savoir si un commentaire a été vérifié
 * @param $review id de l'avis
 */
function ValidateReview(int $review){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT isVisible FROM reviews WHERE id_review=:id');
        $stmt->bindParam(":id", $review, PDO::PARAM_INT);
        if($stmt->execute())
        {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res['isVisible']==1){
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    catch(error $e){
        echo("problème avec les données");
        return false;
    }
}

function ModerateReview(int $review){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('SELECT isVisible, date_check FROM reviews WHERE id_review=:id');
        $stmt->bindParam(":id", $review, PDO::PARAM_INT);
        if($stmt->execute())
        {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res['isVisible']==0 && $res['date_check']!=null){
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    catch(error $e){
        echo("problème avec les données");
        return false;
    }
}

function now(){
    $now = date('Y-m-d',time());
    return $now;
}

function addReviewRequest(Review $review){
    try{
        $pseudo = $review->getPseudo();
        $visite = now();
        $note = $review->getNote();
        $comment = $review->getComment();

        $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
        $stmt = $pdo->prepare('insert into reviews (pseudo, date_visite,note,comment,isVisible) VALUES (:pseudo, :dateVisite, :note,:comment, 0)');
        $stmt->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(":dateVisite", $visite, PDO::PARAM_STR);
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
        $stmt->execute();
    }
    catch(error $e){
        echo("problème avec les données");
        return false;
    }

}

