<?php

use pwf\basic\Application;

/**
 * Working with translations
 */
class Translation
{

    use \pwf\components\i18n\traits\ParamReplace;

    /**
     * Set current language
     *
     * @param string $lang
     */
    public static function setLanguage($lang)
    {
        Application::$instance->i18n->setLanguage($lang);
        \Config::set('i18n.language', $lang);
    }

    /**
     * Get default language
     *
     * @return string
     */
    public static function getDefaultLanguage()
    {
        return Application::$instance->i18n->getDefaultLanguage();
    }

    /**
     * Get language
     *
     * @return string
     */
    public static function getLanguage()
    {
        return \Config::get('i18n.language');
    }

    /**
     * Get translation
     *
     * @param string $key
     * @param array $params
     * @param string $default
     * @return string
     */
    public static function translate($key, array $params = [], $default = '')
    {
        $result = Application::$instance->getComponent('i18n')->translate($key,
            $params);

        return empty($result) ? self::prepareValue($default, $params) : $result;
    }
}