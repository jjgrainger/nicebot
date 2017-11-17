<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter
{
    public $client;

    public function __construct($auth = [])
    {
        $this->auth = $auth;

        $this->createClient($auth);
    }

    public function createClient($auth)
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => $auth['api_key'],
            'consumer_secret' => $auth['api_secret'],
            'token'           => $auth['access_token'],
            'token_secret'    => $auth['access_secret'],
        ]);

        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }


    public function request($method, $uri, $options)
    {
        return $this->client->request($method, $uri, $options);
    }

    public function timeline($user, $count = 5) {
        $response = $this->client->request('GET', 'statuses/user_timeline.json', [
            'query' => [
                'screen_name' => $user,
                'count' => $count
            ]
        ]);

        return $response->getBody();
    }

}
