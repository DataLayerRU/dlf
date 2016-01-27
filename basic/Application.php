<?php

namespace pwf\basic;

use pwf\web\Request;
use pwf\web\Response;
use pwf\exception\interfaces\HttpException;

class Application implements \pwf\basic\interfaces\Application
{

    use \pwf\components\eventhandler\traits\CallbackTrait;
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
     * @return Application
     */
    public function setConfiguration($config = [])
    {
        $this->configuration = $config;
        return $this;
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
     * @return Application
     */
    public function appendConfiguration($config)
    {
        $this->setConfiguration(array_merge($this->getConfiguration(), $config));
        return $this;
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
            $this->forceComponentLoading();

            $callback = $this->prepareCallback(RouteHandler::getHandler($this->request->getPath()));

            if (is_array($callback) && $callback[0] instanceof \pwf\basic\interfaces\Controller) {
                $callback[0]->setRequest($this->getRequest())->setResponse($this->getResponse());
            }

            $this->response->setBody(\pwf\helpers\SystemHelpers::call($callback,
                    function($paramName) {
                    if (($component = $this->getComponent($paramName)) !== null) {
                        return $component;
                    }
                    if (filter_has_var(INPUT_GET, $paramName)) {
                        return filter_input(INPUT_GET, $paramName);
                    }
                    if (filter_has_var(INPUT_POST, $paramName)) {
                        return filter_input(INPUT_POST, $paramName);
                    }
                }));

            $this->response->send();
        } catch (HttpException $ex) {
            $this->sendHeaders($ex->getHeaders());
        } catch (\Exception $ex) {
            echo '<h2>Handled exception</h2>';
            echo '<h3>'.$ex->getMessage().'</h3>';
            echo '<pre>';
            echo $ex->getTraceAsString();
            echo '</pre>';
        }
    }

    /**
     * Force component loading
     *
     * @return \pwf\basic\Application
     */
    protected function forceComponentLoading()
    {
        $config = $this->getConfiguration();
        foreach ($config as $key => $params) {
            if (isset($params['class']) && isset($params['force'])) {
                $this->getComponent($key);
            }
        }
        return $this;
    }

    /**
     * Send headers
     *
     * @param array $headers
     * @return Application
     */
    protected function sendHeaders($headers)
    {
        foreach ($headers as $header) {
            header($header);
        }
        return $this;
    }

    /**
     * Get component by name
     *
     * @param string $name
     * @return Component
     */
    public function getComponent($name)
    {
        if (!isset($this->componentCache[$name]) && ($this->componentCache[$name]
            = $this->createComponent($name)) !== null) {
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