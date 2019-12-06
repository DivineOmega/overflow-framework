<?php

namespace DivineOmega\OverflowFramework\Http;

use DivineOmega\OverflowFramework\Routing\Router;
use DivineOmega\OverflowFramework\Exceptions\FrameworkSetupException;

class Application
{
    private $router;
    private $viewsDirectory;
    private $cacheDirectory;

    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    public function setViewsDirectory(string $viewsDirectory)
    {
        $this->viewsDirectory = $viewsDirectory;
        return $this;
    }

    public function setCacheDirectory(string $cacheDirectory)
    {
        $this->cacheDirectory = $cacheDirectory;
        return $this;
    }

    public function start()
    {
        if (!$this->router) {
            throw new FrameworkSetupException();
        }

        $request = Request::createFromGlobals();

        $response = $this->router->route($request);

        $response->prepare($request);
        $response->send();
    }
}