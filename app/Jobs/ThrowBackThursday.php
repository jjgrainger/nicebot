<?php

namespace App\Jobs;

use App\Scheduler\Job;

class ThrowBackThursday extends Job
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
        $this->log->info("Start job ThrowBackThursday");

        $post = $this->getRandomPost();

        $message = $this->getMessage();

        $replace = [
            '{{title}}' => $post->title,
            '{{link}}' => $post->url
        ];

        $message = str_replace(array_keys($replace), array_values($replace), $message);

        $response = $this->tweet($message);

        $this->log->info("ThrowbackThursday tweet created, id: {$response->id}");
    }

    public function getMessage()
    {
        $messages = [
            "Throwback to one of our favourites sites in the Gallery - {{title}} #tbt #ThrowbackThursday via @OhThatsNice_ {{link}}",
            "Throwback to this nice design - {{title}} #tbt #ThrowbackThursday via @OhThatsNice_ {{link}}",
        ];

        // return a random message
        return $messages[array_rand($messages)];
    }

    public function getRandomPost()
    {
        $response = $this->api->get('posts.json');

        // decode the json respone
        $data = json_decode($response->getBody());

        // remove the latest 10 posts
        $posts = array_slice($data->data, 10);

        // return a random post
        return $posts[array_rand($posts)];
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
