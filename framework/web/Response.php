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
     * @var string
     */
    private $body;

    public function __construct(array $headers = [], array $cookies = [])
    {
        $this->setHeaders($headers);
        $this->setCookies($cookies);
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return Response
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
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
     * @return Response
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * Add cookie
     *
     * @param string $name
     * @param string $value
     * @param intetger $expire
     * @param string $path
     * @return Response
     */
    public function addCookie($name, $value, $expire = null, $path = null)
    {
        $this->cookies[$name] = [
            'value' => $value,
            'expire' => $expire,
            'path' => $path
        ];
        return $this;
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
     * @return Response
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Response
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Clear header and cookie lists
     *
     * @return Response
     */
    public function clear()
    {
        $this->headers = [];
        $this->cookies = [];
        return $this;
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
     * Response type is XML
     *
     * @return bool
     */
    public function isXML()
    {
        return $this->responseType === self::RESPONSE_XML;
    }

    /**
     * Set response type
     *
     * @param integer $type
     * @return Response
     */
    public function setResponseType($type)
    {
        $this->responseType = $type;
        return $this;
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
            $result = json_encode(\pwf\helpers\ArrayHelper::toArray($body));
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
     *
     * @return Response
     */
    protected function sendHeaders()
    {
        $headers = $this->getHeaders();

        foreach ($headers as $header) {
            header($header);
        }
        return $this;
    }

    /**
     * Send cookies
     *
     * @return Response
     */
    protected function sendCookies()
    {
        $cookies = $this->getCookies();

        foreach ($cookies as $name => $cookie) {
            setcookie($name, $cookie['value'], $cookie['expire'],
                $cookie['path']);
        }

        return $this;
    }

    /**
     * Remove cookie
     *
     * @param string $name
     * @return Response
     */
    public function removeCookie($name)
    {
        $this->addCookie($name, null, -1);

        return $this;
    }

    /**
     * Redirect
     *
     * @param string $path
     * @return Response
     */
    public function redirect($path)
    {
        $this->addHeader('Location: '.$path);
        return $this;
    }
}