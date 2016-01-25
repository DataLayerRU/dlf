<?php

namespace pwf\basic\controller;

use pwf\web\Request;

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
     * Set current request
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