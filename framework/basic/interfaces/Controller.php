<?php

namespace pwf\basic\interfaces;

use pwf\web\Request;
use pwf\web\Response;

interface Controller
{

    /**
     * Set current request
     *
     * @param Request $request
     * @return Controller
     */
    public function setRequest(Request $request);

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest();

    /**
     * Set current response object
     *
     * @param Response $response
     * @return Controller
     */
    public function setResponse(Response $response);

    /**
     * Get current response object
     *
     * @return Response
     */
    public function getResponse();
}