<?php

namespace App\Services;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create guzzle client for twitter
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => getenv('TWITTER_API_KEY'),
            'consumer_secret' => getenv('TWITTER_API_SECRET'),
            'token'           => getenv('TWITTER_ACCESS_TOKEN'),
            'token_secret'    => getenv('TWITTER_ACCESS_SECRET'),
        ]);

        $stack->push($middleware);

        $container['twitter'] = new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }
}
