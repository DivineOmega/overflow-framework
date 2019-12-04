<?php


namespace DivineOmega\OverflowFramework\Http;


use DivineOmega\OverflowFramework\Routing\Router;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function start()
    {
        $request = Request::buildFromCurrentRequest();

        $response = $this->router->route($request);

        $response->output();
    }
}