<?php

namespace pwf\basic\interfaces;

interface Component
{
    /**
     * Load configuration
     *
     * @param array $config
     * @return Component
     */
    public function loadConfiguration(array $config = []);

    /**
     * Component initialization
     *
     * @return Component
     */
    public function init();
}