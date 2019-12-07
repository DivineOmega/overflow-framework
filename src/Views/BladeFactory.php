<?php

namespace DivineOmega\OverflowFramework\Views;

use Jenssegers\Blade\Blade;

abstract class BladeFactory
{
    private static $viewsDirectory;
    private static $cacheDirectory;
    private static $blade;

    public static function setDirectories(string $viewsDirectory, string $cacheDirectory)
    {
        self::$viewsDirectory = $viewsDirectory;
        self::$cacheDirectory = $cacheDirectory;
    }

    public static function getBladeInstance()
    {
        if (!self::$blade) {
            mkdir(self::$viewsDirectory, 0777, true);
            mkdir(self::$cacheDirectory, 0777, true);
            self::$blade = new Blade(self::$viewsDirectory, self::$cacheDirectory);
        }

        return self::$blade;
    }
}