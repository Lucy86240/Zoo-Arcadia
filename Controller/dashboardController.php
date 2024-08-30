<?php
//on execute le programme si on est sur une page différente du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/dashboardController.php'){
    try{
        include_once "Controller/ManageAnimal.php";

        /**
         * Summary of housingsPopularity donne les habitats en fonction de leur popularité
         * @return array: housings : name, pathImg, numberClics
         */
        function housingsPopularity(){
            $housingsObject= housingsOrderByPopularity();
            $housings=[];
            if(count($housingsObject)>3)$lenght=3;
            else $lenght = count($housingsObject);
            for($i=0;$i<$lenght;$i++){
                $housing = array(
                    "name" => $housingsObject[$i]->getName(),
                    "pathImg" => $housingsObject[$i]->getImage(0)->getPath(),
                    "numberClics" => $housingsObject[$i]->getNumberOfClics(),
                );
                array_push($housings,$housing);
            }
    
            return $housings;
        }
    
        //on récupère la popularité des habitats et des animaux
        $animals = animalsWithPopularity();
        $housings =  housingsPopularity();
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    // on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
