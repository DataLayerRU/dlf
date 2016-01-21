<?php

namespace pwf\basic;
use pwf\exception\HttpNotFoundException;

/**
 * Route handler
 */
class RouteHandler
{
    /**
     * Registered paths
     * string: controllers\namespace\Controller::action
     * closure: function(){}
     *
     * @var array
     */
    private static $routes = [];

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

        $path = '/' . rtrim($path, " /");

        foreach (static::$routes as $key => $handler) {
            if (preg_match('#' . addslashes($key) . '$#i', $path)) {
                $result = $handler;
                break;
            }
        }

        return $result;
    }

    /**
     * Evaluate handler
     *
     * @param string $path
     * @return mixed
     */
    public static function evalHandler($path)
    {
        $result = null;

        $handler = static::getHandler($path);

        if (is_string($handler)) {
            $ca         = static::parseHandler($handler);
            $controller = new $ca['controller'];
            $result     = $controller->$ca['action']();
        } elseif ($handler instanceof \Closure) {
            $result = $handler();
        } else {
            throw new \Exception('Not ');
        }

        return $result;
    }

    /**
     * Parse handler
     *
     * @param string $handler
     * @return arrat
     */
    public static function parseHandler($handler)
    {
        $result = [];

        $parts = explode('::', $handler);

        $result['controller'] = isset($parts[0]) ? $parts[0] : null;
        $result['action']     = isset($parts[1]) ? $parts[1] : null;

        return $result;
    }
}