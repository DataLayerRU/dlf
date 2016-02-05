<?php

namespace pwf\components\eventhandler\traits;

trait EventTrait
{

    use CallbackTrait;

    /**
     * Register event handler
     *
     * @param mixed $type
     * @param \Closure|array|string $callback
     * @return $this
     */
    public function on($type, $callback)
    {
        if (!isset($this->callbacks[$type])) {
            $this->callbacks[$type] = [];
        }
        $this->callbacks[$type][] = $callback;
        return $this;
    }

    /**
     * Trigger event
     *
     * @param mixed $type
     * @return $this
     */
    public function trigger($type)
    {
        if (isset($this->callbacks[$type])) {
            foreach ($this->callbacks[$type] as $cb) {
                \pwf\helpers\SystemHelpers::call($this->prepareCallback($cb));
            }
        }
        return $this;
    }
}