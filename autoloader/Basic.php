<?php

namespace dlf\autoloader;

class Basic extends Handler
{

    public function load($_className)
    {
        $ClassFullPath = __DIR__."/../../".str_replace("\\", "/", $_className).".php";
        if (file_exists($ClassFullPath)) {
            require_once($ClassFullPath);
        }
    }
}