<?php

namespace dlf\traits;

trait HeadersTrait
{
    private $headers = [];

    /**
     * Set header list
     *
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Get header list
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
     * Clear headers
     */
    public function clearHeaders()
    {
        $this->setHeaders([]);
    }
}