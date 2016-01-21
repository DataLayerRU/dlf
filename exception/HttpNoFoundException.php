<?php

namespace pwf\exception;

use Exception;

class HttpNotFoundException extends Exception
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct('Not found', 404, $previous);
    }
}