<?php

namespace pwf\basic;

abstract class Component implements \pwf\basic\interfaces\Component
{
    /**
     * Force initialization
     *
     * @var bool
     */
    private $forceInit;

    /**
     * Gets or sets flag
     *
     * @param bool $flag
     * @return \pwf\basic\Comonent
     */
    public function isForceInitialization($flag = null)
    {
        if ($flag === null) {
            return $this->forceInit;
        }
        $this->forceInit = $flag;
        return $this;
    }

    /**
     * Configuration loading
     *
     * @param array $config
     */
    public function loadConfiguration($config = [])
    {
        if (isset($config['force'])) {
            $this->isForceInitialization((bool) $config['force']);
        }
    }
}