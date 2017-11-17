<?php

namespace App\Services;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // create logger
        $log = new Logger('nicebot');
        $log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

        $container['logger'] = $log;
    }
}
