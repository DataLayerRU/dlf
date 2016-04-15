<?php

declare(strict_types=1);

namespace pwf\autoloader;

abstract class Handler
{

    final public function getHandler()
    {
        return array($this, 'load');
    }

    abstract public function load(string $className);
}