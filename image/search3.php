<?php

//include_once __DIR__ . '/vendor/autoload.php';
include_once '../../google-api-php-client-2.2.1/vendor/autoload.php';

//$GCSE_API_KEY = "nqwkoigrhe893utnih_gibberish_q2ihrgu9qjnr";
$GCSE_API_KEY = "AIzaSyD1KORf2kRrS7r6n5rT4nwL9QBGD8QCAgk";
//$GCSE_SEARCH_ENGINE_ID = "937592689593725455:msi299dkne4de";
$GCSE_SEARCH_ENGINE_ID = '016724384925099384635:s9jmb6xrf-w';

$client = new Google_Client();
$client->setApplicationName("My_App");
$client->setDeveloperKey($GCSE_API_KEY);
$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>self::GCSE_SEARCH_ENGINE_ID);    
$results = $service->cse->listCse("lol cats", $optParams);