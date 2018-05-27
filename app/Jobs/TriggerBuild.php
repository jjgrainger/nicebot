<?php

namespace App\Jobs;

use App\Scheduler\Job;

class TriggerBuild extends Job
{
    function __construct($container)
    {
        $this->netlify = $container['netlify'];
        $this->log = $container['logger'];
    }

    public function handle()
    {
        $response = $this->triggerBuild();

        $this->log->info("Netlify build triggered");
    }

    /**
     * Trigger a build on Netlify
     */
    public function triggerBuild()
    {
        return $this->netlify->request('POST', '/build_hooks/' . getenv('NETLIFY_BUILD_HOOK_ID'));
    }
}
