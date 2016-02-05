<?php

namespace pwf\autoloader;

require_once(dirname(__FILE__).'/Handler.php');
require_once(dirname(__FILE__).'/Basic.php');

class Autoloader
{

    public static function register(Handler $handler)
    {
        spl_autoload_register($handler->GetHandler());
    }
}