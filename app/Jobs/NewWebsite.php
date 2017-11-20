<?php

namespace App\Jobs;

use App\Scheduler\Job;
use Carbon\Carbon;

class NewWebsite extends Job
{
    function __construct($container)
    {
        // get the ohthatsnice.net api
        $this->api = $container['ohthatsnice'];
        $this->twitter = $container['twitter'];
        $this->log = $container['logger'];
    }

    public function handle()
    {
        $this->log->info("Start job NewWebsite");

        $post = $this->getLatestPost();

        // parse the post date for comparison
        $postDate = Carbon::parse($post->date);

        // make sure the post is todays date
        if ($postDate->isToday()) {
            // tweet this post
            $response = $this->tweet($post);

            $this->log->info("New post tweeted, id: {$response->id}");
        }

        $this->log->info("End job NewWebsite");
    }

    public function getLatestPost()
    {
        $response = $this->api->get('posts.json');

        $data = json_decode($response->getBody());

        // get the latest post
        return $data->data[0];
    }

    public function tweet($post)
    {
        // create tweet text
        $tweet = "New site in the gallery - {$post->title} #webdesign #inspiration via @OhThatsNice_ {$post->url}";
        // post to twitter
        $response = $this->twitter->request('POST', 'statuses/update.json', [
            'query' => [
                'status' => $tweet
            ]
        ]);

        return json_decode($response->getBody());
    }
}
