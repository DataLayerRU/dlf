<?php

namespace pwf\web;

class Response
{
    /**
     * Response body as text
     */
    const RESPONSE_RAW = 0;

    /**
     * Response body as JSON
     */
    const RESPONSE_JSON = 2;

    /**
     * Response body as XML
     *
     * NOT IMPLEMENTED YET
     */
    const RESPONSE_XML = 3;

    /**
     * Response type
     *
     * @var integer
     */
    private $responseType = 0;

    /**
     * Headers
     *
     * @var array
     */
    private $headers;

    /**
     * Cookies
     *
     * @var array
     */
    private $cookies;

    /**
     * Request body
     *
     * @var mixed
     */
    private $body;

    public function __construct($headers = [], $cookies = [])
    {
        $this->setHeaders($headers);
        $this->setCookies($cookies);
    }

    /**
     * Set headers
     *
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Get cookies
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Set cookies
     *
     * @param array $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * Add cookie
     *
     * @param string $name
     * @param string $value
     * @param intetger $expire
     * @param string $path
     */
    public function addCookie($name, $value, $expire = null, $path = null)
    {
        $this->cookies[$name] = [
            'value' => $value,
            'expire' => $expire,
            'path' => $path
        ];
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Add single header
     *
     * @param string $header
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     * Set body
     *
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Set body
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Clear header list
     */
    public function clear()
    {
        $this->headers = [];
    }

    /**
     * Response type is text
     *
     * @return bool
     */
    public function isRaw()
    {
        return $this->responseType === self::RESPONSE_RAW;
    }

    /**
     * Response type is JSON
     *
     * @return bool
     */
    public function isJson()
    {
        return $this->responseType === self::RESPONSE_JSON;
    }

    /**
     * Set response type
     *
     * @param integer $type
     */
    public function setResponseType($type)
    {
        $this->responseType = $type;
    }

    /**
     * Prepare response body for sending
     *
     * @return string
     */
    protected function prepareBody()
    {
        $body = $this->body;

        $result = $body;

        if ($this->isJson() && (is_array($body) || is_object($body))) {
            $result = json_encode($body);
        }

        return $result;
    }

    /**
     * Send response
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendCookies();

        echo $this->prepareBody();
    }

    /**
     * Send headers
     */
    protected function sendHeaders()
    {
        $headers = $this->getHeaders();

        foreach ($headers as $header) {
            header($header);
        }
    }

    /**
     * Send cookies
     */
    protected function sendCookies()
    {
        $cookies = $this->getCookies();

        foreach ($cookies as $name => $cookie) {
            setcookie($name, $cookie['value'], $cookie['expire'], $cookie['path']);
        }
    }

    /**
     * Remove cookie
     *
     * @param string $name
     */
    public function removeCookie($name)
    {
        $this->addCookie($name, null, -1);
    }

    /**
     * Redirect
     *
     * @param string $path
     */
    public function redirect($path)
    {
        $this->addHeader('Location: ' . $path);
    }
}