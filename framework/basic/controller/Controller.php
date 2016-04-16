<?php

declare(strict_types = 1);

namespace pwf\basic\controller;

use pwf\web\Request;
use pwf\web\Response;
use pwf\basic\interfaces\Controller as IController;

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
     * @return IController
     */
    public function setRequest(Request $request): IController
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Set current response object
     *
     * @param Response $response
     * @return IController
     */
    public function setResponse(Response $response): IController
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Get current response object
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}