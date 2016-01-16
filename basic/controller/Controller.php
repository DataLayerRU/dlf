<?php

namespace dlf\basic\controller;

use dlf\web\Request;

class Controller
{
    private $request;

    public function __construct()
    {
        
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}