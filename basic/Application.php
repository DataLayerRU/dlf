<?php

namespace pwf\basic;

use pwf\web\Request;
use pwf\web\Response;

class Application implements \pwf\basic\interfaces\Application
{
    /**
     * Current application
     *
     * @var Application
     */
    public static $instance;

    /**
     * Component cache
     *
     * @var array
     */
    private $componentCache = [];

    /**
     * Current configuration
     *
     * @var array
     */
    private $configuration = [];

    /**
     * Request object
     *
     * @var pwf\web\Request
     */
    private $request;

    /**
     * Response
     *
     * @var pwf\web\Response
     */
    private $response;

    public function __construct($config = [])
    {
        $this->request  = new Request($_REQUEST);
        $this->response = new Response();
        $this->setConfiguration($config);

        static::$instance = $this;
    }

    /**
     * Get current request
     *
     * @return pwf\web\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get current response
     *
     * @return pwf\web\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set configuration
     *
     * @param array $config
     */
    public function setConfiguration($config = [])
    {
        $this->configuration = $config;
    }

    /**
     * Get configuration
     *
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Append configuration
     *
     * @param array $config
     */
    public function appendConfiguration($config)
    {
        $this->setConfiguration(array_merge($this->getConfiguration(), $config));
    }

    /**
     * Get configuration for component by name
     *
     * @param string $componentName
     * @return array
     */
    public function getComponentConfig($componentName)
    {
        $result = null;
        $config = $this->getConfiguration();
        if (isset($config[$componentName])) {
            $result = $config[$componentName];
        }
        return $result;
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            $this->response->setBody(RouteHandler::evalHandler($this->request->getPath()));

            $this->response->send();
        } catch (\Exception $ex) {
            echo '<h2>Handled exception</h2>';
            echo '<pre>';
            echo $ex->getTraceAsString();
            echo '</pre>';
        }
    }

    /**
     * Get component by name
     *
     * @param string $name
     * @return Component
     */
    public function getComponent($name)
    {
        if (!isset($this->componentCache[$name])) {
            $this->componentCache[$name] = $this->createComponent($name);
            $this->componentCache[$name]->init();
        }

        return $this->componentCache[$name];
    }

    /**
     * Create component/module by name
     *
     * @param string $name
     * @return \interfaces\Component
     * @throws \Exception
     */
    protected function createComponent($name)
    {
        $result = null;

        $config = $this->getComponentConfig($name);

        if ($config !== null && isset($config['class'])) {
            $result = new $config['class'];
            if ($result instanceof \pwf\basic\interfaces\Component) {
                $result->loadConfiguration($config);
            } else {
                throw new \Exception('Component must implement \'Component\' interface',
                    500);
            }
        }

        return $result;
    }
}