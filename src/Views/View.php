<?php

namespace DivineOmega\OverflowFramework\Views;

class View
{
    private $view;
    private $viewData;

    public function __construct(string $view, array $viewData = [])
    {
        $this->view = $view;
        $this->viewData = $viewData;
    }

    public function render()
    {
        return BladeFactory::getBladeInstance()
            ->make($this->view, $this->viewData)
            ->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}