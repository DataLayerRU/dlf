<?php

namespace dlf\basic\controller;

use dlf\web\Request;

class Controller
{
    /**
     * Current request
     *
     * @var Request
     */
    private $request;

    public function __construct()
    {
        
    }

    /**
     * Set request object
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}