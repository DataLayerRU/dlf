<?php

namespace pwf\components\eventhandler\interfaces;

interface EventHandler
{

    /**
     * Handler registration
     *
     * @param string $type
     * @param \Callback|array|string $callback
     */
    public function on($type, $callback);

    /**
     * Trigger event
     *
     * @param string $type
     */
    public function trigger($type);
}