<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;

class BladeServiceProvider
{
    private static $factory;

    public static function init()
    {
        $filesystem = new Filesystem();
        $resolver = new EngineResolver();
        $finder = new FileViewFinder($filesystem, [__DIR__ . '/../view']);
        $cachePath = __DIR__ . '/../cache';

        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        // Compiler Engine với BladeCompiler
        $resolver->register('blade', function () use ($filesystem, $cachePath) {
            return new CompilerEngine(new BladeCompiler($filesystem, $cachePath));
        });

        self::$factory = new Factory($resolver, $finder, new Dispatcher());
    }

    public static function render($view, $data = [])
    {
        if (!self::$factory) {
            self::init();
        }

        if (!self::$factory->exists($view)) {
            die("Blade Error: View '$view' does not exist.");
        }

        echo self::$factory->make($view, $data)->render();
    }
}
