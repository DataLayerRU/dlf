<?php

declare(strict_types = 1);

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
    public static function registerHandler(string $path, $handler)
    {
        static::$routes[$path] = $handler;
    }

    /**
     * Get handler
     *
     * @param string $path
     * @return mixed
     */
    public static function getHandler(string $path)
    {
        $result = null;

        $path = '/' . rtrim($path, " /");

        foreach (static::$routes as $key => $handler) {
            $matches = [];
            if (preg_match('#' . $key . '$#i', $path, $matches)) {
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
    public static function parseRoute(string $url): string
    {
        $result = '';

        $parts = explode('/', $url);

        $action = static::preparePart(array_pop($parts), true);
        $parts[count($parts) - 1] = static::preparePart($parts[count($parts) - 1]) . 'Controller';
        $controller = '\\project\\controllers' . implode('\\',
                $parts);

        if ($action != '' && $controller != '') {
            $result = $controller . '::' . $action;
        }

        return $result;
    }

    /**
     * Converts main-action to mainAction
     *
     * @param string $part
     * @return string
     */
    public static function preparePart(string $part, bool $firstLower = false): string
    {
        $result = str_replace(' ', '', ucwords(str_replace('-', ' ', $part)));
        if ($firstLower && mb_strlen($result) > 0) {
            $result[0] = mb_strtolower($result[0]);
        }
        return $result;
    }
}