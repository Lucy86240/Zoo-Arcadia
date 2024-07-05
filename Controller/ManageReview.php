<?php

include_once "Model/ManageReviewModel.php";

/**Fonction reviews
 * permet d'avoir un tableau associatif avec les informations souhaités des avis selon un filtre et trie
 * @param int $nbReviews : nombre d'avis souhaités
 * @param int $startList : indice du 1er avis (utile pour la pagination)
 * @param bool $justVisible : true si on souhaite seulement des avis valides
 * @param string $filter : chaine de caractères du filtre souhaité (par exemple : " date_check is not null") 
 * @param string $sort : "idC" = id_review croissants, "idD" = id_review decroissants, 
 * "DvC" = dates de visite croissants, "DvD" = dates de visite décroissants, 
 * "NC" = notes croissantes, "ND" = notes décroissantes
 * @param bool $ElementIsVisible : true si on veut que dans le tableau associatif il y ait isVisible
 * @param bool $ElementDateCheck : true si on veut que dans le tableau associatif il y ait date_check
 * @param bool $ElementCheckBy : true si on veut que dans le tableau associatif il y ait l'id du vérificateur
 */
function reviews(int $nbReviews, int $startList,bool $justVisible,string $filter, string $sort, bool $ElementIsVisible, bool $ElementDateCheck, bool $ElementCheckBy){
    $reviewsObject = reviewsExtract($nbReviews,$startList,$sort,$justVisible,$filter);
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
        if($ElementDateCheck){
            $review["dateCheck"] = $reviewObject->getDateCheck();
        }
        if($ElementCheckBy){
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

/**Fonction filterInit permet de mettre la mention checked à une checkbox en cas de besoin
 *  @param $filter : nom du $_GET qui correspond au filtre souhaité
 * @param $check : nom du $_POST associé à ce filtre
 */
function filterInit($filter, $check){
    if((isset($_GET[$filter]) && $_GET[$filter]=='true') ||
    (!isset($_GET[$filter]) && isset($_POST['choices']) && isset($_POST[$check])) ||
    (!isset($_GET['page']) && !isset($_POST['choices'])) )  echo('checked');  
}

function filterRequestReview(){
    $validate = " not (date_check is not null and isVisible = 1)";
    $and = " AND";
    $toValidate = " date_check is not null";
    $moderate = " not (date_check is not null and isVisible=0)";
    $filter = "";
    if(isset($_POST['choices']) && !isset($_POST['CheckValidateReviews'])){
        $filter =$validate;
    }
    else{
        if(isset($_GET['Validate']) && $_GET['Validate'] =='false'){
            $filter =$validate;
        }
    }

    if(isset($_POST['choices']) && !isset($_POST['CheckToValidateReviews'])){
        if($filter!=""){
            $filter .=$and.$toValidate;
        }else{
            $filter .=$toValidate;
        }
    }
    else {
        if(isset($_GET['ToValidate']) && $_GET['ToValidate']=='false'){
            if($filter!=""){
                $filter .=$and.$toValidate;
            }else{
                $filter .=$toValidate;
            }
        }
    }

    if(isset($_POST['choices']) && !isset($_POST['CheckModerateReviews'])){
        if($filter!=""){
            $filter .=$and.$moderate;
        }
        else{
            $filter .=$moderate;
        }
    }
    else{
        if(isset($_GET['Moderate']) && $_GET['Moderate']=='false'){
            if($filter!=""){
                $filter .=$and.$moderate;
            }
            else{
                $filter .=$moderate;
            }
        }
    }
    return $filter;
}

function urlFilter(){
    $url ='';
        if((isset($_POST['choices']) && isset($_POST['CheckValidateReviews'])) ||
        (isset($_GET['Validate']) && $_GET['Validate'] =='true')){
            $url.='&Validate=true';
        }
        else{
            $url.='&Validate=false';
        }

        if((isset($_POST['choices']) && isset($_POST['CheckToValidateReviews']))||
        (isset($_GET['ToValidate']) && $_GET['ToValidate']=='true')){
            $url.='&ToValidate=true';
        }
        else{
            $url.='&ToValidate=false';
        }

        if((isset($_POST['choices']) && isset($_POST['CheckModerateReviews']))||
        (isset($_GET['Moderate']) && $_GET['Moderate']=='true')){
            $url.='&Moderate=true';
        }
        else{
            $url.='&Moderate=false';
        }

    return $url;
}

function urlSort(){
    $url = "";
    if(isset($_POST['choices'])){
        $url = "&trie=".$_POST['sort'];
    }
    else if(isset ($_GET['trie'])){
        $url = "&trie=".$_GET['trie'];
    }
    return $url;
}
function urlOption($page, $optionPage,$filter,$sort){
    $url="";
    if(!$optionPage) $url.="avis/";
    $url.="?page=".$page.$filter.$sort;

    echo($url);
}

function sortReview(){
    $sort = "";
    if(isset($_POST['choices'])) $sort = $_POST['sort'];
    else if(isset($_GET['trie'])) $sort = $_GET['trie'];
    return $sort;
}

function sortInit($sortInit){
    if((isset($_GET['trie']) && $sortInit==$_GET['trie']) || 
    (isset($_POST['sort']) && $_POST['sort']==$sortInit)){
        echo('checked');
    }
    else if($sortInit=='DvD'){
        echo('checked');
    }
}

// On détermine le nombre d'avis par page
$perPage = 2;

// On détermine sur quelle page on se trouve
    if((isset($_GET['page']) && !empty($_GET['page']))&& !isset($_POST['filter'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    //on détermine le 1er avis à afficher
    $firstAvis = ($currentPage * $perPage) - $perPage;
    
    //on détermine le filtre et le trie à appliquer
    $filter = filterRequestReview();
    $sort = sortReview();
    //on récupère les avis
    $reviews = reviews($perPage,$firstAvis,false,$filter, $sort, true, true, true);

    //on compte le nombre d'avis    
    $nbReviews = countReviewsFilter($filter);

    // On calcule le nombre de pages total
    $pages = ceil($nbReviews / $perPage);
