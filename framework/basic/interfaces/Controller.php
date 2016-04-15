<?php

declare(strict_types = 1);

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
    public function setRequest(Request $request): Controller;

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest(): Request;

    /**
     * Set current response object
     *
     * @param Response $response
     * @return Controller
     */
    public function setResponse(Response $response): Controller;

    /**
     * Get current response object
     *
     * @return Response
     */
    public function getResponse(): Response;
}