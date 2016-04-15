<?php

declare(strict_types=1);

namespace pwf\autoloader;

class Basic extends Handler
{

    public function load(string $className)
    {
        $classFullPath = __DIR__ . "/../../../../../" . str_replace("\\", "/",
                $className) . ".php";
        if (file_exists($classFullPath)) {
            require_once($classFullPath);
        }
    }
}