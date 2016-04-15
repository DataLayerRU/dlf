<?php

declare(strict_types = 1);

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
    public function setHeaders(array $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get cookies
     *
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * Set cookies
     *
     * @param array $cookies
     * @return Response
     */
    public function setCookies($cookies): Response
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * Add cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @return Response
     */
    public function addCookie(string $name, string $value, int $expire = null, string $path = null): Response
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
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Add single header
     *
     * @param string $header
     * @return Response
     */
    public function addHeader(string $header): Response
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
    public function setBody(string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set body
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Clear header and cookie lists
     *
     * @return Response
     */
    public function clear(): Response
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
    public function isRaw(): bool
    {
        return $this->responseType === self::RESPONSE_RAW;
    }

    /**
     * Response type is JSON
     *
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->responseType === self::RESPONSE_JSON;
    }

    /**
     * Response type is XML
     *
     * @return bool
     */
    public function isXML(): bool
    {
        return $this->responseType === self::RESPONSE_XML;
    }

    /**
     * Set response type
     *
     * @param int $type
     * @return Response
     */
    public function setResponseType(int $type): Response
    {
        $this->responseType = $type;
        return $this;
    }

    /**
     * Prepare response body for sending
     *
     * @return string
     */
    protected function prepareBody(): string
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
     *
     * @return Response
     */
    public function send(): Response
    {
        $this->sendHeaders();
        $this->sendCookies();

        echo $this->prepareBody();

        return $this;
    }

    /**
     * Send headers
     *
     * @return Response
     */
    protected function sendHeaders(): Response
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
    protected function sendCookies(): Response
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
    public function removeCookie(string $name): Response
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
    public function redirect(string $path): Response
    {
        $this->addHeader('Location: ' . $path);
        return $this;
    }
}