<?php

namespace pwf\exception;

use pwf\exception\abstraction\HttpExceptionAbstract;

class HttpBadRequestException extends HttpExceptionAbstract
{

    public function __construct(Exception $previous = null)
    {
        parent::__construct($this->getContent(), 400, $previous);

        $this->addHeader('HTTP/1.1 400 Bad request');
    }

    public function getContent()
    {
        return '400. Bad request.';
    }
}