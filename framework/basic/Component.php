<?php

declare(strict_types = 1);

namespace pwf\basic;

use pwf\basic\interfaces\Component as IComponent;

abstract class Component extends Object implements \pwf\basic\interfaces\Component
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
     * @return IComponent
     */
    public function isForceInitialization(bool $flag = null): IComponent
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
     * @return IComponent
     */
    public function loadConfiguration(array $config = []): IComponent
    {
        if (isset($config['force'])) {
            $this->isForceInitialization((bool)$config['force']);
        }
        return $this;
    }
}