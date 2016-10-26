<?php

namespace pwf\exception;

use pwf\exception\abstraction\HttpExceptionAbstract;

class HttpNotFoundException extends HttpExceptionAbstract
{

    public function __construct(Exception $previous = null)
    {
        parent::__construct($this->getContent(), 404, $previous);

        $this->addHeader('HTTP/1.0 404 Not Found');
    }

    public function getContent()
    {
        return '404. Not found.';
    }
}