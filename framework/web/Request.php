<?php

namespace pwf\web;

class Request
{
    /**
     * Request parametres
     *
     * @var array
     */
    private $requestParams;

    /**
     * URL segments
     *
     * @var array
     */
    private $urlParts;

    public function __construct(array $requestParams = [])
    {
        $this->requestParams = $requestParams;
        $this->urlParts      = $this->devideUrl();
    }

    /**
     * Set params
     *
     * @param array $params
     * @return Request
     */
    public function setRequestParams(array $params)
    {
        $this->requestParams = $params;
        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * Get current path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->get('path', '');
    }

    /**
     * Get param value by name
     *
     * @param string $paramName
     * @param mixed $default
     * @return mized
     */
    public function get($paramName = null, $default = null)
    {
        $result = $default;

        $params = $this->getRequestParams();

        if ($paramName === null) {
            $result = $params;
        } elseif (isset($params[$paramName])) {
            $result = $params[$paramName];
        }

        return $result;
    }

    /**
     * Check is method POST
     *
     * @return bool
     */
    public function isPost()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    /**
     * Check is method GET
     *
     * @return bool
     */
    public function isGet()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
    }

    /**
     * Get cookie's value by name
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getCookie($name, $default = null)
    {
        $result = $default;

        if (isset($_COOKIE[$name])) {
            $result = $_COOKIE[$name];
        }

        return $result;
    }

    /**
     * Get file by name
     *
     * @param string $fileName
     * @return array|false
     */
    public function getFile($fileName)
    {
        $result = false;

        if (isset($_FILES[$fileName])) {
            $result = $_FILES[$fileName];
        }

        return $result;
    }

    /**
     * Get URL segment
     *
     * @param int $index
     * @param string $default
     * @return string
     */
    public function getSegment($index, $default = null)
    {
        return $index > 0 && count($this->urlParts) - 1 <= $index ? $this->urlParts[$index]
                : $default;
    }

    /**
     * Devide url on segments
     *
     * @return array
     */
    protected function devideUrl()
    {
        $parts = explode('/', $this->getPath());
        $cnt   = count($parts);
        for ($i = 0; $i < $cnt; $i++) {
            $parts[$i] = trim($parts[$i]);
        }
        return $parts;
    }
}