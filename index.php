<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Pimple\Container;

// load .env
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$app = new Container;

$services = [
    App\Services\LogProvider::class,
    App\Services\TwitterProvider::class,
];

foreach ($services as $service) {
    $app->register(new $service);
}

// events to run
$events = [
    App\Events\FollowUser::class
];

// cycle through each event and run them
foreach ($events as $event) {
    (new $event($app))->run();
}
