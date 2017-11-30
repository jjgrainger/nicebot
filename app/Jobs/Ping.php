<?php

namespace App\Jobs;

use App\Scheduler\Job;
use Carbon\Carbon;

class Ping extends Job
{
    function __construct($container)
    {
        $this->log = $container['logger'];
    }

    public function handle()
    {
        $this->log->info("Ping!");
    }
}
