<?php

require_once "Route.php";

//    function __construct($url, $title, $pathHtml, $authorize, $pathController)
$allRoutes = array(
    new Route('','Accueil','View/pages/home.php',[],'Controller/AllController.php'),
    new Route('avis','Avis','View/pages/review.php',[],''),
);

define('ALL_ROUTES',$allRoutes);

define('WEBSITE_NAME' ,'Arcadia');

define('ROUTE404',new Route('404','Page introuvable','View/pages/404.php',[],''));