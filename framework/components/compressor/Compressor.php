<?php

namespace pwf\components\compressor;

use pwf\basic\interfaces\Application;

class Compressor implements \pwf\basic\interfaces\Plugin
{
    /**
     * Current application
     *
     * @var Application
     */
    private $app;

    public function init()
    {
        return $this;
    }

    public function loadConfiguration(array $config = array())
    {
        return $this;
    }

    public function register(Application $app)
    {
        $app->on(Application::EVENT_AFTER_HANDLER, [$this, 'compress']);
        $this->app = $app;
        return $this;
    }

    public function compress()
    {
        $body = $this->app->getResponse()->getBody();
        if (is_string($body)) {
            $this->app->getResponse()->setBody(\pwf\helpers\StringHelpers::minify($body));
        }
    }

    public function unregister()
    {
        return $this;
    }
}