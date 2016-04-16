<?php

declare(strict_types = 1);

namespace pwf\web;

class Request
{
    /**
     * Request parametres
     *
     * @var array
     */
    private $requestParams;

    public function __construct(array $requestParams = [])
    {
        $this->requestParams = $requestParams;
    }

    /**
     * Set params
     *
     * @param array $params
     * @return Request
     */
    public function setRequestParams(array $params): Request
    {
        $this->requestParams = $params;
        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * Get current path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->get('path', '');
    }

    /**
     * Get param value by name
     *
     * @param string $paramName
     * @param mixed $default
     * @return mixed
     */
    public function get(string $paramName = null, $default = null)
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
    public function isPost(): bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    /**
     * Check is method GET
     *
     * @return bool
     */
    public function isGet(): bool
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
    public function getCookie(string $name, string $default = null): string
    {
        $result = $default;

        if (isset($_COOKIE[$name])) {
            $result = $_COOKIE[$name];
        }

        return $result;
    }
}