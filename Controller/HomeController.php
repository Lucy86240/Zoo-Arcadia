<?php
if($_SERVER['REQUEST_URI']!='/Controller/HomeController.php'){
    include_once "Controller/ManageHousing.php";
    include_once "Controller/ManageService.php";
    include_once "Controller/ManageReview.php";
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}