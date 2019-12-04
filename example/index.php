<?php

use DivineOmega\OverflowFramework\Http\Application;
use DivineOmega\OverflowFramework\Routing\Router;

require_once __DIR__.'/../vendor/autoload.php';

$router = new Router();
$router->addRoute('GET', '/', function() {
    return 'hello';
});

(new Application($router))->start();