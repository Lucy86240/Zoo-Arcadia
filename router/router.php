<?php

    require_once 'config.php';
    require_once 'AllRoutes.php';
    require_once "Controller/ManageUser.php";

    //HTTP protocol + Server address(localhost or example.com) + requested uri (/route or /route/home)
    $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    //Current URL = http://localhost:3000/something
    //Site URL - http://localhost:3000/

    //Requested page = Current URL - Site URL
    //Requested page = something
    $request = str_replace($site_url, '', $current_url);

    $request = strtolower($request);

    function getRouteByUrl($url,$option){

        $currentRoute = null;

      // Parcours de toutes les routes pour trouver la correspondance
        foreach(ALL_ROUTES as $route){
            if ($route->getURL() == $url && $option == $route->getOption() && authorize($route->getAuthorize())) {
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

    function optionPage($request){
        $request = explode('/',$request,2);
        if(count($request)>1){
            return true;
        }
        else{
            return false;
        }
    }

    function loadContentPage($request){
        $option = optionPage($request);
        $request = explode('/',$request,2);

        $actualRoute = getRouteByUrl($request[0],$option);


        if($actualRoute->getPathController()!=null)
        {
            include $actualRoute->getPathController();
        }

        if($actualRoute->getPathHtml()!=null){
            include $actualRoute->getPathHtml();
        }
    }