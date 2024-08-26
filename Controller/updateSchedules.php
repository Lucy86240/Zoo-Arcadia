<?php

require_once 'Controller/schedules.php';

if(isset($_POST['schedules'])){
    $collection->updateOne(
        [ 'text' => ['$exists'=>true] ],
        [ '$set' => [ 'text' => $_POST['schedules']]]
    );
}