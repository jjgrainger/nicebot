<?php

namespace App\Jobs;

use App\Scheduler\Job;
use Carbon\Carbon;

class LinkToSite extends Job
{
    function __construct($container)
    {
        $this->api = $container['ohthatsnice'];
        $this->twitter = $container['twitter'];
        $this->log = $container['logger'];
    }

    public function handle()
    {
        // get a random tweet message
        $tweet = $this->getRandomTweet();
        // add the url to the end
        $tweet .= " https://ohthatsnice.net";

        // tweet it
        $response = $this->tweet($tweet);

        $this->log->info("Tuesday tweet, id: {$response->id}");
    }

    public function getRandomTweet()
    {
        $tweets = [
            "If you're looking for web design #inspiration, look no further",
            "Check out the some latest #inspiration in the gallery",
            "There's a lovely collection of sites growing over here, come take a look",
            "Looking for some inspiration? Come take a look...",
            "Take a look at some of the nice websites featured in the gallery",
            "after some web design inspiration? Check otu some of the latest sites in the gallery"
        ];

        return $tweets[array_rand($tweets)];
    }

    public function tweet($tweet)
    {
        // post to twitter
        $response = $this->twitter->request('POST', 'statuses/update.json', [
            'query' => [
                'status' => $tweet
            ]
        ]);

        return json_decode($response->getBody());
    }
}
