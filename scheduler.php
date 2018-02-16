<?php

require __DIR__ . '/app/bootstrap.php';

use App\Scheduler\Kernal;
use Carbon\Carbon;

while(true) {

    $container = $app->getContainer();

    $schedule = new Kernal;

    // set current time for testing
    // $schedule->setDate(Carbon::parse('2017/11/15 12:00:34'));

    // Ping for testing
    // $schedule->add(new App\Jobs\Ping($container))->everyMinute();

    // Follow a user based on twitter list
    $schedule->add(new App\Jobs\FollowUser($container))->dailyAt(12, 30);

    // tweet the new website for the day
    $schedule->add(new App\Jobs\NewWebsite($container))->dailyAt(12);

    // tweet throwback thursday
    $schedule->add(new App\Jobs\ThrowBackThursday($container))->at(15)->thursdays();

    // tweet link to site advertising inspiration
    $schedule->add(new App\Jobs\LinkToSite($container))->at(12)->tuesdays();

    // trigger a travis build nightly
    $schedule->add(new App\Jobs\TriggerBuild($container))->dailyAt(1);

    // tweet call for submissions
    $schedule->add(new App\Jobs\SubmitASite($container))->at(15)->tuesdays();
    $schedule->add(new App\Jobs\SubmitASite($container))->at(12)->thursdays();

    $schedule->run();

    sleep(60);
}
