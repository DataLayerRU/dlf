<?php

namespace dlf\autoloader;

abstract class Handler
{

    final public function getHandler()
    {
        return array($this, 'load');
    }

    abstract public function load($className);
}