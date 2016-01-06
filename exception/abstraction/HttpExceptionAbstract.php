<?php

namespace dlf\exception\abstraction;

use dlf\traits\HeadersTrait;
use dlf\exception\interfaces\HttpException;

abstract class HttpExceptionAbstract extends \Exception implements HttpException
{

    use HeadersTrait;

    public function __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->clearHeaders();
    }
}