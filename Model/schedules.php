<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/schedules.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    function schedules(){
        try{        
            //on retourne le texte correspondant aux horaires
                    //on se connecte à la base de données
                    $client = new MongoDB\Client(MONGO_DB_HOST);
                    $collection = $client->Arcadia->schedules;
            return $collection->findOne(['text' => ['$exists'=>true]])['text'];
        }catch(error $e){
            return 'oups nous ne trouvons pas les horaires';
        }
    }

    function modifySchedules(string $text){
        try{        
            //on se connecte à la base de données
                $client = new MongoDB\Client(MONGO_DB_HOST);
                $collection = $client->Arcadia->schedules;
                //on la met à jour
                $collection->updateOne(
                    [ 'text' => ['$exists'=>true] ],
                    [ '$set' => [ 'text' => $text]]
                );
        }catch(error $e){
            echo('oups nous ne parvenons pas à modifier les horaires');
        }
    }
}
