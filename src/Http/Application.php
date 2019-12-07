<?php

namespace DivineOmega\OverflowFramework\Http;

use DivineOmega\OverflowFramework\Routing\Router;
use DivineOmega\OverflowFramework\Exceptions\FrameworkSetupException;
use DivineOmega\OverflowFramework\Views\BladeFactory;

class Application
{
    private $router;
    private $rootDirectory;

    public function setRootDirectory(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
        return $this;
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    public function start()
    {
        if (!$this->router) {
            throw new FrameworkSetupException('No router specified.');
        }

        if (!$this->rootDirectory) {
            throw new FrameworkSetupException('No root directory specified.');
        }

        if (!is_dir($this->rootDirectory)) {
            throw new FrameworkSetupException('Specified root directory is not a directory.');
        }

        BladeFactory::setDirectories(
            $this->rootDirectory.'/views/',
            $this->rootDirectory.'/cache/views/'
        );

        $request = Request::createFromGlobals();

        $response = $this->router->route($request);

        $response->prepare($request);
        $response->send();
    }
}