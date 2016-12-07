<?php

use pwf\basic\Application;

/**
 * Working with translations
 */
class Translation extends Config
{

    /**
     * Set current language
     *
     * @param string $lang
     */
    public static function setLanguage($lang)
    {
        self::set('i18n.language', $lang);
    }

    /**
     * Get translation
     *
     * @param string $key
     * @param array $params
     * @return string
     */
    public static function translate($key, array $params = [])
    {
        return Application::$instance->getComponent('i18n')->translate($key,
                $params);
    }
}