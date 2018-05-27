<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use GuzzleHttp\Client;

class NetlifyServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create guzzle client for ohthatsnice api
        $container['netlify'] = new Client([
            'base_uri' => 'https://api.netlify.com/',
        ]);
    }
}
