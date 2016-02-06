<?php

namespace pwf\autoloader;

class Basic extends Handler
{

    public function load($className)
    {
        $classFullPath = __DIR__."/../../../../../".str_replace("\\", "/",
                $className).".php";
        if (file_exists($classFullPath)) {
            require_once($classFullPath);
        }
    }
}