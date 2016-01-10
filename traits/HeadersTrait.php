<?php

namespace dlf\traits;

trait HeadersTrait
{
    private $headers = [];

    /**
     * Set header list
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
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
     * @return $this
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Clear headers
     *
     * @return $this
     */
    public function clearHeaders()
    {
        $this->setHeaders([]);
        return $this;
    }
}