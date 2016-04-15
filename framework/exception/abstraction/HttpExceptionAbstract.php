<?php

declare(strict_types = 1);

namespace pwf\exception\abstraction;

use pwf\traits\HeadersTrait;
use pwf\exception\interfaces\HttpException;

abstract class HttpExceptionAbstract extends \Exception implements HttpException
{

    use HeadersTrait;

    public function __construct(string $message, int $code, \Exception $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->clearHeaders();
    }
}