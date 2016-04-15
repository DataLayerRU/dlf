<?php

declare(strict_types = 1);

namespace pwf\components\eventhandler\interfaces;

interface EventHandler
{

    /**
     * Handler registration
     *
     * @param string $type
     * @param \Callback|array|string $callback
     */
    public function on(string $type, $callback);

    /**
     * Trigger event
     *
     * @param string $type
     */
    public function trigger(string $type);
}