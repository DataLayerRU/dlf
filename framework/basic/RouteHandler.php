<?php

namespace pwf\basic;

/**
 * Route handler
 */
class RouteHandler
{
    const DEFAULT_CONTROLLER = 'Main';
    const DEFAULT_ACTION     = 'index';

    /**
     * Registered paths
     * string: controllers\namespace\Controller::action
     * closure: function(){}
     *
     * @var array
     */
    private static $routes = [];

    /**
     * \Closures for route preprocessing
     *
     * @var array
     */
    private static $preprocessors = [];

    /**
     * Register handler
     *
     * @param string $path
     * @param mixed $handler
     */
    public static function registerHandler($path, $handler)
    {
        static::$routes[$path] = $handler;
    }

    /**
     * Get handler
     *
     * @param string $path
     * @return mixed
     */
    public static function getHandler($path)
    {
        $result = null;

        $path = self::prepareRoute('/'.trim($path, " /"));

        foreach (static::$routes as $key => $handler) {
            $matches = [];
            if (preg_match('#'.$key.'$#i', $path, $matches)) {
                foreach ($matches as $key => $val) {
                    if (!is_numeric($key)) {
                        $_GET[$key] = $val;
                    }
                }
                $result = $handler;
                break;
            }
        }

        if ($result === null) {
            $result = self::parseRoute($path);
        }

        return $result;
    }

    /**
     * Parse url to callable
     *
     * @param string $url
     * @return string
     */
    public static function parseRoute($url)
    {
        $result = null;

        $parts = explode('/', $url);
        if (count($parts) === 2) {
            $parts[1] = $parts[1] === '' ? self::DEFAULT_CONTROLLER : $parts[1];
            $parts[2] = self::DEFAULT_ACTION;
        }

        $action                   = static::preparePart(array_pop($parts), true);
        $parts[count($parts) - 1] = static::preparePart($parts[count($parts) - 1]).'Controller';
        $controller               = '\\project\\controllers'.implode('\\',
                $parts);

        if ($action != '' && $controller != '') {
            $result = $controller.'::'.$action;
        }

        return $result;
    }

    /**
     * Converts main-action to mainAction
     *
     * @param string $part
     * @return string
     */
    public static function preparePart($part, $firstLower = false)
    {
        $result = str_replace(' ', '', ucwords(str_replace('-', ' ', $part)));
        if ($firstLower && mb_strlen($result) > 0) {
            $result[0] = mb_strtolower($result[0]);
        }
        return $result;
    }

    /**
     * Add route preprocessor
     *
     * @param \Closure $preprocessor
     */
    public static function addPreprocessor(\Closure $preprocessor)
    {
        self::$preprocessors[] = $preprocessor;
    }

    /**
     * Prepare route
     *
     * @param string $route
     * @return string
     */
    protected static function prepareRoute($route)
    {
        foreach (self::$preprocessors as $preprocessor) {
            $route = $preprocessor($route);
        }
        return $route;
    }
}