<?php

namespace pwf\basic;

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

        $action                   = array_pop($parts);
        $parts[count($parts) - 1] = str_replace(' ', '',
                ucwords(str_replace('-', ' ', $parts[count($parts) - 1]))).'Controller';
        $controller               = '\\project\\controllers'.implode('\\',
                $parts);

        if ($action != '' && $controller != '') {
            $result = $controller.'::'.$action;
        }

        return $result;
    }
}