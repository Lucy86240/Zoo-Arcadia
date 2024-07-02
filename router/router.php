<?php

    require_once 'config.php';
    require_once 'AllRoutes.php';

    //HTTP protocol + Server address(localhost or example.com) + requested uri (/route or /route/home)
    $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    //Current URL = http://localhost:3000/something
    //Site URL - http://localhost:3000/

    //Requested page = Current URL - Site URL
    //Requested page = something
    $request = str_replace($site_url, '', $current_url);

    //Replacing extra back slash at the end
    $request = str_replace('/', '', $request);

    //Converting the request to lowercase
    $request = strtolower($request);

    function getRouteByUrl($url){

        $currentRoute = null;

      // Parcours de toutes les routes pour trouver la correspondance
        foreach(ALL_ROUTES as $route){
            if ($route->getURL() == $url) {
                $currentRoute = $route;
            }
        }

      // Si aucune correspondance n'est trouvée, on retourne la route 404
        if ($currentRoute != null) {
        return $currentRoute;
        } 
        else {
            return ROUTE404;
        }
    }

    function loadContentPage($request){
        $actualRoute = getRouteByUrl($request);

        if($actualRoute->getPathController()!=null)
        {
            include $actualRoute->getPathController();
        }

        if($actualRoute->getPathHtml()!=null){
            include $actualRoute->getPathHtml();
        }
    }