<?php

include_once "Model/ManageReviewModel.php";

/** Fonction reviews
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
            "dateVisite" => date("d/m/Y",strtotime($reviewObject->getDateVisite())),
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

/** Fonction filterInit permet de mettre la mention checked à une checkbox en cas de besoin
 *  @param $filter : nom du $_GET qui correspond au filtre souhaité
 * @param $check : nom du $_POST associé à ce filtre
 */
function filterInit($filter, $check){
    if((isset($_GET[$filter]) && $_GET[$filter]=='true') ||
    (!isset($_GET[$filter]) && isset($_POST['choices']) && isset($_POST[$check])) ||
    (!isset($_GET['page']) && !isset($_POST['choices'])) )  echo('checked');  
}

/**
 * Summary of filterRequestReview : en fonction des filtes choisis retourne la condition à indiquer dans la requete de la base de données
 * @return string
 */
function filterRequestReview(){
    //conditions de requete
    $validate = " not (date_check is not null and isVisible = 1)";
    $and = " AND";
    $toValidate = " date_check is not null";
    $moderate = " not (date_check is not null and isVisible=0)";
    $filter = "";

    //si on fait un filtre et qu'on ne coche pas validé
    if(isset($_POST['choices']) && !isset($_POST['CheckValidateReviews'])){
        $filter =$validate;
    }
    else{
        //si on ne fait pas de filtre mais qu'on fait un filtre sur une page antérieure sans la coche validé
        if(isset($_GET['Validate']) && $_GET['Validate'] =='false'){
            $filter =$validate;
        }
    }

    //si on fait un filtre et qu'on ne coche pas à vérifier
    if(isset($_POST['choices']) && !isset($_POST['CheckToValidateReviews'])){
        //si un filtre existe déjà
        if($filter!=""){
            $filter .=$and.$toValidate;
        }else{
            $filter .=$toValidate;
        }
    }
    else {
        //si on ne fait pas de filtre mais qu'on fait un filtre sur une page antérieure sans la coche à vérifier
        if(isset($_GET['ToValidate']) && $_GET['ToValidate']=='false'){
            if($filter!=""){
                $filter .=$and.$toValidate;
            }else{
                $filter .=$toValidate;
            }
        }
    }

    //si on fait un filtre et qu'on ne coche pas modéré
    if(isset($_POST['choices']) && !isset($_POST['CheckModerateReviews'])){
        if($filter!=""){
            $filter .=$and.$moderate;
        }
        else{
            $filter .=$moderate;
        }
    }
    else{
        //si on ne fait pas de filtre mais qu'on fait un filtre sur une page antérieure sans la coche modérer
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

/**
 * Summary of urlFilter : retourne la partie de l'url à indiquer pour que les filtres s'appliquent d'une page à l'autre
 * @return string
 */
function urlFilter(){
    $url ='';
        if((isset($_POST['choices']) && isset($_POST['CheckValidateReviews'])) ||
        (isset($_GET['Validate']) && $_GET['Validate'] =='true') ||
        (!isset($_POST['choices']) && !isset($_GET['page']))){
            $url.='&Validate=true';
        }
        else{
            $url.='&Validate=false';
        }

        if((isset($_POST['choices']) && isset($_POST['CheckToValidateReviews']))||
        (isset($_GET['ToValidate']) && $_GET['ToValidate']=='true') ||
        (!isset($_POST['choices']) && !isset($_GET['page']))){
            $url.='&ToValidate=true';
        }
        else{
            $url.='&ToValidate=false';
        }

        if((isset($_POST['choices']) && isset($_POST['CheckModerateReviews']))||
        (isset($_GET['Moderate']) && $_GET['Moderate']=='true') ||
        (!isset($_POST['choices']) && !isset($_GET['page']))){
            $url.='&Moderate=true';
        }
        else{
            $url.='&Moderate=false';
        }

    return $url;
}

/**
 * Summary of urlSort : retourne la partie de l'url à indiquer en cas de trie 
 * autre que celui par défaut afin qu'il s'applique d'une page à l'autre
 * @return string
 */
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
/**
 * Summary of urlOption affiche l'url complet afin de gérer la pagination / filtre / trie
 * @param mixed $page : le numéro de la page
 * @param mixed $optionPage : true si on a déjà des paramétres sur la page en cours
 * @param mixed $filter : urlfiter
 * @param mixed $sort : urlSort
 * @return void
 */
function urlOption($page, $optionPage,$filter,$sort){
    $url="";
    if(!$optionPage) $url.="avis/";
    $url.="?page=".$page.$filter.$sort;

    echo($url);
}

/**
 * Summary of sortReview : retourne quel trie est demandé
 * @return mixed
 */
function sortReview(){
    $sort = "";
    if(isset($_POST['choices'])) $sort = $_POST['sort'];
    else if(isset($_GET['trie'])) $sort = $_GET['trie'];
    return $sort;
}

/**
 * Summary of sortInit : coche la bonne case de trie par appliquer (soit celle par défaut soit celle de l'url) 
 * @param mixed $sortInit
 * @return void
 */
function sortInit($sortInit){
    if((isset($_GET['trie']) && $sortInit==$_GET['trie']) || 
    (isset($_POST['sort']) && $_POST['sort']==$sortInit)){
        echo('checked');
    }
    else if($sortInit=='DvD'){
        echo('checked');
    }
}

/**
 * Summary of validVerif : permet de valider les vérifications apportées aux avis (validé, supprimé, modéré)
 * @param mixed $currentPage : page en cours (peut le modifier en fonction des vérifications)
 * @param mixed $reviews : les avis (peuvent être modifiés en fonction des vérifications)
 * @param mixed $pages : le nombre de pages (peut être modifié en fonction des vérifications)
 * @param mixed $nbReviews : le nombre d'avis à afficher
 * @return void
 */
function validVerif(&$currentPage,&$reviews,&$pages,&$nbReviews){
    if(isset($_POST['valid-verif'])){
        for($i=0;$i<$nbReviews;$i++){
            //on récupère le nom des boutons radios de l'avis en cours
            $name = 'status'.$i;
            //s'il le bouton radio existe
            if(isset($_POST[$name])){
                if(($_POST[$name]=='validate'&& !validateReview($reviews[$i]['id'])) ||
                $_POST[$name]=='moderate'&& !moderateReview($reviews[$i]['id']) ||
                $_POST[$name]=='delete'
                ){
                    //on modifie la base de données
                    updateReview($reviews[$i]['id'],$_POST[$name]);
                }
                
            }
        }
        //on réinitialise le bouton
        $_POST['valid-verif']=null;
        //on réaffiche les avis
        displayReviews($currentPage,$reviews,$pages,$nbReviews);
    }
    
}

/**
 * Summary of addReview : permet d'ajouter un avis
 * @return void
 */
function addReview(){
    //si on a cliqué sur ajouter
    if(isset($_POST['addReview'])){
        //un crée un objet review avec les infos renseignées
        $review = new Review();
        if(isset($_POST['NewReviewPseudo'])) $review->setPseudo($_POST['NewReviewPseudo']);
        if(isset($_POST['NewReviewComment'])) $review->setComment($_POST['NewReviewComment']);
        if(isset($_POST['stars'])) $review->setNote($_POST['stars']);
        //on l'ajoute à la base de données
        addReviewRequest($review);
    }
}
/**
 * Summary of displayReviews : permet de récupérer les informations pour afficher les avis
 * @param mixed $currentPage : renseigner la page à afficher
 * @param mixed $reviews : les avis qui seront à afficher
 * @param mixed $pages : le nombre de page qui existera
 * @param mixed $nbReviews : le nombre d'avis qui sera affiché
 * @return void
 */
function displayReviews($currentPage,&$reviews,&$pages,&$nbReviews){
// On détermine le nombre d'avis par page
    $perPage = 10;
//on détermine le 1er avis à afficher
    $firstAvis = ($currentPage * $perPage) - $perPage;
    
//on détermine le filtre et le trie à appliquer
    if(isConnected()) $filter = filterRequestReview();
    //sans connexion seulement les avis validés sont accessibles
    else $filter = 'isVisible = 1';
    $sort = sortReview();

    //on récupère les avis de la base de données
    $reviews = reviews($perPage,$firstAvis,false,$filter, $sort, true, true, true);
    
    //on compte le nombre d'avis    
    $nbReviews = countReviewsFilter($filter);
    
    // On calcule le nombre de pages totales
    $pages = ceil($nbReviews / $perPage);

    //fin de la fonction
}



//on indique si l'url a des paramètres
if(empty($_GET['page'])){
    $optionPage = false;
}
else{
    $optionPage = true;
}

// On détermine sur quelle page on se trouve
    if((isset($_GET['page']) && !empty($_GET['page']))&& !isset($_POST['filter'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    //on récupère les infos clés pour l'affichage des avis
    $reviews=null;
    $pages=null;
    $nbReviews=0;
    displayReviews($currentPage,$reviews,$pages,$nbReviews);

    //on ajoute un nouvel avis en cas de soumission
    addReview();

    //on met à jour la bd en fonction des vérifications effectuées
    validVerif($currentPage,$reviews,$pages,$nbReviews);
