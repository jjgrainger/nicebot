<?php

require __DIR__ . '/app/bootstrap.php';

use App\Scheduler\Kernal;
use Carbon\Carbon;


$container = $app->getContainer();

$schedule = new Kernal;

// set current time for testing
// $schedule->setDate(Carbon::parse('2017/11/15 12:00:34'));

// Ping for testing
// $schedule->add(new App\Jobs\Ping($container))->everyMinute();

$schedule->add(new App\Jobs\SubmitASite($container))->everyMinute();

$schedule->run();

