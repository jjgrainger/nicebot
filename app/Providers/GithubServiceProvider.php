<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use GuzzleHttp\Client;

class GithubServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create guzzle client for GitHub API
        $container['github'] = new Client([
            'base_uri' => 'https://api.github.com',
            'headers' => [
                "Content-Type" =>  "application/json",
                "Accept" =>  "application/json",
                'Authorization' => 'token ' . getenv('GITHUB_API_TOKEN'),
                'User-Agent' => 'nicebot',
            ]
        ]);
    }
}
