<?php

use DivineOmega\OverflowFramework\Http\Application;
use DivineOmega\OverflowFramework\Http\Request;
use DivineOmega\OverflowFramework\Routing\Router;

require_once __DIR__.'/../vendor/autoload.php';

$router = new Router();
$router->get('/', function(Request $request) {
    return 'Hello '.$request->get('name');
});

(new Application($router))->start();