<?php

namespace pwf\basic\controller;

use pwf\web\Request;
use pwf\web\Response;

class Controller implements \pwf\basic\interfaces\Controller
{
    /**
     * Current request
     *
     * @var Request
     */
    private $request;

    /**
     *
     * @var Response
     */
    private $response;

    public function __construct()
    {
        
    }

    /**
     * Set current request
     *
     * @param Request $request
     * @return Controller
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
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

    /**
     * Set current response object
     *
     * @param Response $response
     * @return Controller
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Get current response object
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}