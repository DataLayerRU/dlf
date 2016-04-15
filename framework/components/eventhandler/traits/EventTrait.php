<?php

declare(strict_types = 1);

namespace pwf\components\eventhandler\traits;

trait EventTrait
{

    use CallbackTrait;

    /**
     * Register event handler
     *
     * @param string $type
     * @param \Closure|array|string $callback
     * @return $this
     */
    public function on(string $type, $callback)
    {
        if (!isset($this->callbacks[$type])) {
            $this->callbacks[$type] = [];
        }
        $this->callbacks[$type][] = $callback;
        return $this;
    }

    /**
     * Clear callbacks
     * 
     * @return $this
     */
    public function clear()
    {
        $this->callbacks = [];
        return $this;
    }

    /**
     * Trigger event
     *
     * @param string $type
     * @return $this
     */
    public function trigger(string $type)
    {
        if (isset($this->callbacks[$type])) {
            foreach ($this->callbacks[$type] as $cb) {
                \pwf\helpers\SystemHelpers::call($this->prepareCallback($cb));
            }
        }
        return $this;
    }
}