<?php

namespace pwf\components\eventhandler\interfaces;

interface EventHandler
{

    /**
     * Handler registration
     *
     * @param mixed $type
     * @param \Callback|array|string $callback
     */
    public function on($type, $callback);

    /**
     * Trigger event
     *
     * @param mixed $type
     */
    public function trigger($type);
}