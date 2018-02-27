<?php

namespace App\Jobs;

use App\Scheduler\Job;

class SubmitASite extends Job
{
    public function __construct($container)
    {
        // get the ohthatsnice.net api
        $this->api = $container['ohthatsnice'];
        $this->twitter = $container['twitter'];
        $this->log = $container['logger'];
    }

    public function handle()
    {
        $this->log->info("Start job SumitASite");

        $message = $this->getMessage();

        $replace = [
            '{{link}}' => 'https://ohthatsnice.net/submit-a-website/'
        ];

        $message = str_replace(array_keys($replace), array_values($replace), $message);

        $response = $this->tweet($message);

        $this->log->info("SumbitASite tweet created, id: {$response->id}");
    }

    public function getMessage()
    {
        $messages = [
            "Launched a new website recently? Why not have it featured on @OhThatsNice_ {{link}}",
            "We love a personal portfolio website, why not add yours? #webdesign #webdev {{link}}",
            "We're always looking out for beautiful websites, submit a site today! #webdesign #inspiration {{link}}",
            "We're always hungry for lovely looking websites! Help feed our appetite by sumbitting a site today {{link}}",
            "We've got a lovely growing collection of websites in the gallery, why not add yours? {{link}}",
        ];

        // return a random message
        return $messages[array_rand($messages)];
    }

    public function tweet($tweet)
    {
        $response = $this->twitter->request('POST', 'statuses/update.json', [
            'query' => [
                'status' => $tweet
            ]
        ]);

        return json_decode($response->getBody());
    }
}
