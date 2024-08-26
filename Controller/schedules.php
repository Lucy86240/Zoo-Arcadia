<?php

$client = new MongoDB\Client(MONGO_DB_HOST);

$collection = $client->Arcadia->schedules;

$schedules = $collection->findOne(['text' => ['$exists'=>true]])['text'];