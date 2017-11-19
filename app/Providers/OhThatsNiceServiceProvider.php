<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class OhThatsNiceServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create guzzle client for ohthatsnice api
        $container['ohthatsnice'] = new Client([
            'base_uri' => 'https://ohthatsnice.net/api/',
        ]);
    }
}
