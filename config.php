<?php
 if($_SERVER['REQUEST_URI']=='/config.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    require 'vendor/autoload.php'; // include Composer's autoloader

    //Location of your site which contains route.php
    $site_url = 'https://still-fjord-33756-159b74d5ae59.herokuapp.com/';
    
    define('SITE_URL','https://still-fjord-33756-159b74d5ae59.herokuapp.com/');
    define('MAIL_CONTACT','contact@arcadia.com');
    define('DATA_BASE','mysql:host=b4e9xxkxnpu2v96i.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=nw68eqcmtkwxvnaq');
    define('USERNAME_DB','m0593g3r35li7ysd');
    define('PASSEWORD_DB','pieraznwj0hv0el8');

    define('MONGO_DB_HOST', 'mongodb://localhost:27017');
}
