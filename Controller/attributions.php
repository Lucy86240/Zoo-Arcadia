<?php
if($_SERVER['REQUEST_URI']!='/Controller/attributions.php'){
    require_once "Model/Image.php";
    $attributions = listAttributions();
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
