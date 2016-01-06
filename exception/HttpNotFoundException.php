<?php

namespace dlf\exception;

use dlf\exception\abstraction\HttpExceptionAbstract;

class HttpNotFoundException extends HttpExceptionAbstract
{

    public function __construct(Exception $previous = null)
    {
        parent::__construct('Not found', 404, $previous);

        $this->addHeader('HTTP/1.0 404 Not Found');
    }

    public function getContent()
    {
        return '404. Not found.';
    }
}