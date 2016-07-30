<?php

namespace pwf\components\eventhandler\traits;

trait CallbackTrait
{
    /**
     * Callbacks grouped by type
     *
     * @var array
     */
    private $callbacks = [];

    /**
     * Get callbacks
     *
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }

    /**
     * Set callbacks
     *
     * @param array $callbacks
     * @return $this
     */
    public function setCallbacks(array $callbacks)
    {
        $this->callbacks = $callbacks;
        return $this;
    }

    /**
     * Prepare handler for invokation
     *
     * @param \Closure|string|array $callback
     * @return \Closure
     * @throws \pwf\exception\HttpNotFoundException
     */
    public function prepareCallback($callback)
    {
        $result       = $callback;
        if (is_string($callback) && ($callbackInfo = $this->parseHandlerStr($callback))
            && class_exists($callbackInfo['class'])) {
            $result = [new $callbackInfo['class'], $callbackInfo['method']];
        } elseif (!is_callable($callback)) {
            throw new \pwf\exception\HttpNotFoundException();
        }
        return $result;
    }

    /**
     * Parse handler
     *
     * @param string $handler
     * @return array
     */
    protected function parseHandlerStr($handler)
    {
        $result = [];

        $parts = explode('::', $handler);

        $result['class']  = isset($parts[0]) ? $parts[0] : null;
        $result['method'] = isset($parts[1]) ? $parts[1] : null;

        return $result;
    }
}