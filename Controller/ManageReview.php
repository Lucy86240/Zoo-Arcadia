<?php

include_once "Model/ManageReviewModel.php";

function reviews(int $nbReviews, int $startList, bool $justVisible, bool $ElementIsVisible, bool $dateCheck, bool $checkBy){
    $reviewsObject = reviewsExtract($nbReviews,$startList,"DvD",$justVisible);
    $reviews = [];
    foreach($reviewsObject as $reviewObject){
        $review = array(
            "id" => $reviewObject->getId(),
            "pseudo" => $reviewObject->getPseudo(),
            "dateVisite" => $reviewObject->getDateVisite(),
            "note" => $reviewObject->getNote(),
            "comment" => $reviewObject->getComment(),
        );
        if($ElementIsVisible){
            $review["visible"] = $reviewObject->getIsVisible();
        }
        if($dateCheck){
            $review["dateCheck"] = $reviewObject->getDateCheck();
        }
        if($checkBy){
            $review["CheckBy"] = $reviewObject->getCheckBy();
        }

        array_push($reviews,$review);
    }
    return $reviews;
}

if(empty($_GET['page'])){
    $optionPage = false;
}
else{
    $optionPage = true;
}

// On détermine le nombre d'articles par page
$perPage = 2;

// On détermine sur quelle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    //on détermine le 1er avis à afficher
    $firstAvis = ($currentPage * $perPage) - $perPage;

    //on récupère les avis
    $reviews = reviews($perPage,$firstAvis, false, true, true, true);

    //on compte le nombre d'avis
    $nbReviews = countReviews(2,2);

    // On calcule le nombre de pages total
    $pages = ceil($nbReviews / $perPage);
