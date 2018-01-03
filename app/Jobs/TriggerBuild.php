<?php

namespace App\Jobs;

use App\Scheduler\Job;

class TriggerBuild extends Job
{
    function __construct($container)
    {
        $this->travis = $container['travisci'];
        $this->log = $container['logger'];
    }

    public function handle()
    {
        $response = $this->triggerBuild();

        $data = json_decode($response->getBody());

        $this->log->info("Build triggered: #{$data->request->id}");
    }

    /**
     * Trigger a build on Travis CI
     */
    public function triggerBuild()
    {
        return $this->travis->request('POST', 'repo/jjgrainger%2Fohthatsnice/requests', [
            'request' => [
                'branch' => 'master'
            ]
        ]);
    }
}
