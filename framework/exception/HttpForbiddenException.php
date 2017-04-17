<?php

namespace pwf\exception;

use pwf\exception\abstraction\HttpExceptionAbstract;

class HttpForbiddenException extends HttpExceptionAbstract
{

    public function __construct(Exception $previous = null)
    {
        parent::__construct($this->getContent(), 403, $previous);

        $this->addHeader('HTTP/1.1 403 Forbidden');
    }

    public function getContent()
    {
        return '403. Forbidden.';
    }
}