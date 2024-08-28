<?php
if($_SERVER['REQUEST_URI']=='/Controller/updateSchedules.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    require_once 'Controller/schedules.php';

    if(isset($_POST['schedules']) && isText($_POST['schedules'])){
        $collection->updateOne(
            [ 'text' => ['$exists'=>true] ],
            [ '$set' => [ 'text' => $_POST['schedules']]]
        );
    }
}