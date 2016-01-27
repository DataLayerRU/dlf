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

        $path = '/'.rtrim($path, " /");

        foreach (static::$routes as $key => $handler) {
            if (preg_match('#'.addslashes($key).'$#i', $path)) {
                $result = $handler;
                break;
            }
        }

        return $result;
    }
}