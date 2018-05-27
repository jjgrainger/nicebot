<?php

require __DIR__ . '/../vendor/autoload.php';

// load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

// create the slim app
$app = new Slim\App;

$container = $app->getContainer();

// register services to the container
$services = [
    App\Providers\LogServiceProvider::class,
    App\Providers\TwitterServiceProvider::class,
    App\Providers\OhThatsNiceServiceProvider::class,
    App\Providers\TravisServiceProvider::class,
    App\Providers\NetlifyServiceProvider::class,
];

foreach ($services as $service) {
    $container->register(new $service);
}

// // add routes to the application
// $app->get('/', function ($request, $response, $args) {
//     return $response->write("Hello");
// });

return $app;
