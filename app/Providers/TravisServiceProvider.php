<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TravisServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create guzzle client for ohthatsnice api
        $container['travisci'] = new Client([
            'base_uri' => 'https://api.travis-ci.org/',
            'headers' => [
                "Content-Type" =>  "application/json",
                "Accept" =>  "application/json",
                "Travis-API-Version" =>  "3",
                "Authorization" =>  "token " . getenv('TRAVISCI_TOKEN'),
            ]
        ]);
    }
}
