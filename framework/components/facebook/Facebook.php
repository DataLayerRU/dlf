<?php

namespace pwf\components\facebook;

/**
 * Facebook SDK adapter
 */
class Facebook implements \pwf\basic\interfaces\Component
{
    /**
     * Facebook config
     *
     * @var array
     */
    private $config;

    /**
     * FB class
     *
     * @var \Facebook\Facebook
     */
    private $fc;

    public function init()
    {
        $this->fc = new \Facebook\Facebook($this->config);
        return $this;
    }

    public function loadConfiguration(array $config = array())
    {
        $this->config = $config;
        return $this;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->fc, $name)) {
            return call_user_func_array([$this->fc, $name], $arguments);
        }
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
    }
}