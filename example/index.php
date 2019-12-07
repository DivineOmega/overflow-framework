<?php

use DivineOmega\OverflowFramework\Http\Application;
use DivineOmega\OverflowFramework\Http\Request;
use DivineOmega\OverflowFramework\Routing\Router;
use DivineOmega\OverflowFramework\Views\View;

require_once __DIR__.'/../vendor/autoload.php';

$router = new Router();

$router->get('/', function(Request $request) {
    return 'Homepage';
});

$router->get('/greet/{greeting}/{name}', function(Request $request, $greeting, $name) {
    return $greeting.' '.$name;
});

$router->get('/product/{slug}', function(Request $request, $slug) {
    return new View('product-page', ['slug' => $slug]);
});

(new Application())
    ->setRootDirectory(__DIR__)
    ->setRouter($router)
    ->start();