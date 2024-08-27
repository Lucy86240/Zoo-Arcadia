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
    $site_url = 'http://localhost:3000/';
    
    define('SITE_URL','http://localhost:3000/');
    define('MAIL_CONTACT','contact@arcadia.com');
    define('DATA_BASE','mysql:host=localhost;dbname=arcadia_zoo');
    define('USERNAME_DB','root');
    define('PASSEWORD_DB','');

    define('MONGO_DB_HOST', 'mongodb://localhost:27017');
}
