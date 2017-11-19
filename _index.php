<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Pimple\Container;

// load .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = new Dotenv(__DIR__);
    $dotenv->load();
}

$app = new Container;

$services = [
    App\Services\LogProvider::class,
    App\Services\TwitterProvider::class,
];

foreach ($services as $service) {
    $app->register(new $service);
}

// jobs to run
$jobs = [
    App\Jobs\FollowUser::class
];

// cycle through each event and run them
foreach ($jobs as $job) {
    (new $job($app))->handle();
}

$app['logger']->info('nicebot complete :)');
