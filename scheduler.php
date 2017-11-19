<?php

require __DIR__ . '/app/bootstrap.php';

use App\Scheduler\Kernal;
use Carbon\Carbon;

$container = $app->getContainer();

$schedule = new Kernal;

// set current time for testing
$schedule->setDate(Carbon::parse('2017/11/16 15:00:34'));

// $schedule->add(new App\Jobs\FollowUser($container))->hourlyAt(0);

$schedule->add(new App\Jobs\ThrowBackThursday($container))->at(15, 0)->thursdays();

$schedule->run();


