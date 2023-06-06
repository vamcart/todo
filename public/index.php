<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$app = new App\Core\Application(realpath(__DIR__ . '/../'));

$app->run();
