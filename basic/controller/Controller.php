<?php

namespace dlf\basic\controller;

class Controller
{
    /**
     * Response format
     *
     * @var int
     */
    private $responseFormat;

    public function setResponseFormat($format)
    {
        $this->responseFormat = $format;
        return $this;
    }

    public function getResponseFormat()
    {
        return $this->responseFormat;
    }
}