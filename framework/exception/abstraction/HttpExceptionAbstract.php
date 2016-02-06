<?php

namespace pwf\exception\abstraction;

use pwf\traits\HeadersTrait;
use pwf\exception\interfaces\HttpException;

abstract class HttpExceptionAbstract extends \Exception implements HttpException
{

    use HeadersTrait;

    public function __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->clearHeaders();
    }
}