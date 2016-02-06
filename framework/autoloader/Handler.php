<?php

namespace pwf\autoloader;

abstract class Handler
{

    final public function getHandler()
    {
        return array($this, 'load');
    }

    abstract public function load($className);
}