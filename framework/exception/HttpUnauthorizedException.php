<?php

namespace pwf\exception;

use pwf\exception\abstraction\HttpExceptionAbstract;

class HttpUnauthorizedException extends HttpExceptionAbstract
{

    public function __construct(Exception $previous = null)
    {
        parent::__construct($this->getContent(), 401, $previous);

        $this->addHeader('HTTP/1.1 401 Unauthorized');
    }

    public function getContent()
    {
        return '401. Unauthorized.';
    }
}