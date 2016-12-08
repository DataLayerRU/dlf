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
     * Get language
     *
     * @return string
     */
    public static function getLanguage()
    {
        return self::get('i18n.language');
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