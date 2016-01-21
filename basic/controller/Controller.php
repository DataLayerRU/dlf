<?php

namespace pwf\basic\controller;

use pwf\web\Request;

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