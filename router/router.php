<?php
if($_SERVER['REQUEST_URI']=='/router/router.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    require_once 'config.php';
    require_once 'AllRoutes.php';
    require_once "Controller/ManageUser.php";

        $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        //Current URL = http://localhost:3000/something
        //Site URL - http://localhost:3000/
    
        //Requested page = Current URL - Site URL
        //Requested page = something
        $request = str_replace($site_url, '', $current_url);
    
        $request = strtolower($request);
            //HTTP protocol + Server address(localhost or example.com) + requested uri (/route or /route/home)
    
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
            echo("1:".$option);

            $request = explode('/',$request,2);
            echo("1/2:".$request[1]);
            $actualRoute = getRouteByUrl($request[2],$option);
            $option = optionPage($request);
            $request = explode('/',$request,2);
            $actualRoute = getRouteByUrl($request[2],$option);
            echo("2:".$request);
            if($actualRoute->getPathController()!=null)
            {
                echo("3:".$actualRoute->getPathController());
                include $actualRoute->getPathController();
            }
        
            if($actualRoute->getPathHtml()!=null){
                echo("4:".$actualRoute->getPathHtml());
                include $actualRoute->getPathHtml();
            }
        }
}