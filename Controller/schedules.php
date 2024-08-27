<?php
if($_SERVER['REQUEST_URI']=='/Controller/schedules.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    $client = new MongoDB\Client(MONGO_DB_HOST);

    $collection = $client->Arcadia->schedules;

    $schedules = $collection->findOne(['text' => ['$exists'=>true]])['text'];
}