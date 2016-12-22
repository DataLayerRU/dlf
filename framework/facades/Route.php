<?php

use pwf\basic\RouteHandler;

/**
 * Facade for route
 */
class Route
{

    /**
     * Append with language
     *
     * @param string $path
     * @return string
     */
    public static function to($path)
    {
        $currentLanguage = \Translation::getLanguage();
        if (\Translation::getDefaultLanguage() === $currentLanguage) {
            $currentLanguage = '';
        } else {
            $currentLanguage = '/'.$currentLanguage;
        }
        return $currentLanguage.$path;
    }

    /**
     * Generate path by name
     *
     * @param string $name
     * @return string
     */
    public static function toRoute($name)
    {
        return self::to(RouteHandler::getByName($name)[0]);
    }
}