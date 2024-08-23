<?php
    require 'vendor/autoload.php'; // include Composer's autoloader

    //Location of your site which contains route.php
    $site_url = 'http://localhost:3000/';
    define('SITE_URL','http://localhost:3000/');
    define('MAIL_CONTACT','contact@arcadia.com');
    define('DATA_BASE','mysql:host=localhost;dbname=arcadia_zoo');
    define('USERNAME_DB','root');
    define('PASSEWORD_DB','');

    define('MONGO_DB_USERNAME','');
    define('MONGO_DB_PASSWORD','');
    define('MONGO_DB_HOST',"");
    define('MONGO_DB_PORT',"");
    define('MONGO_DB_DEFAULT_DATABASE_NAME', 'Arcadia');

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->Arcadia->property;
    //$result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

    /*$username_password = MONGO_DB_USERNAME != null && MONGO_DB_USERNAME != "" ? MONGO_DB_USERNAME . ':' . MONGO_DB_PASSWORD . '@' : "";
    $host_and_port = MONGO_DB_HOST . ':' . MONGO_DB_PORT;
    $mongoClient = new Client('mongodb://' . $username_password . $host_and_port, [], [
        'typeMap' => [
            'array' => 'array',
            'document' => 'array',
            'root' => 'array',
        ],
    ]);
    
    $dm = $mongoClient->selectDatabase(MONGO_DB_DEFAULT_DATABASE_NAME ?? 'Arcadia');*/