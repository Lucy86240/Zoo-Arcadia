<?php

include_once "Model/ManageReviewModel.php";

function reviews(int $nbReviews, int $startList, bool $justVisible, bool $ElementIsVisible, bool $dateCheck, bool $checkBy){
    $reviewsObject = reviewsExtract($nbReviews,$startList,"DvD",$justVisible);
    $reviews = [];
    foreach($reviewsObject as $reviewObject){
        $review = array(
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