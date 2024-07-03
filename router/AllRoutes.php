<?php

require_once "Route.php";

//    function __construct($url, $title, $pathHtml, $authorize, $pathController)
$allRoutes = array(
    new Route('',false,'Accueil','View/pages/home.php',[],'Controller/AllController.php'),
    new Route('avis',true,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
    new Route('avis',false,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
);

define('ALL_ROUTES',$allRoutes);

define('WEBSITE_NAME' ,'Arcadia');

define('ROUTE404',new Route('404',false,'Page introuvable','View/pages/404.php',[],''));