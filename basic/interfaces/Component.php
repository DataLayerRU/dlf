<?php

namespace pwf\basic\interfaces;

interface Component
{
    /**
     * Load configuration
     *
     * @param array $config
     */
    public function loadConfiguration($config = []);

    /**
     * Component initialization
     */
    public function init();
}