<?php

use pwf\basic\Application;

/**
 * Working with configuration
 */
class Config
{

    /**
     * Get configuration value
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return Application::$instance->getConfigParam($key);
    }

    /**
     * Set configuration value
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $parts   = explode('.', $key);
        $config  = [];
        $current = &$config;
        foreach ($parts as $part) {
            $current[$part] = [];
            $current        = &$current[$part];
        }
        $current = $value;
        Application::$instance->appendConfiguration($config);
    }
}