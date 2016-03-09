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
        $this->setConfiguration($this->requiredComponents())
            ->appendConfiguration($config);


        static::$instance = $this;
    }

    /**
     * Get current request
     *
     * @return \pwf\web\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get current response
     *
     * @return \pwf\web\Response
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
                    if (isset($_GET[$paramName])) {
                        return $_GET[$paramName];
                    }
                    if (isset($_POST[$paramName])) {
                        return $_POST[$paramName];
                    }
                })
            );
        } catch (HttpException $ex) {
            $this->response->setHeaders($ex->getHeaders());
            $this->response->setBody($ex->getContent());
        } catch (\Exception $ex) {
            $this->response->setHeaders([
                'HTTP/1.1 500 Internal Server Error'
            ]);
            $this->response->setBody('<h2>Handled exception</h2>'
                .'<h3>'.$ex->getMessage().'</h3>'
                .'<pre>'
                .$ex->getTraceAsString()
                .'</pre>');
        }
        $this->response->send();
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
            if (!($result instanceof \pwf\basic\interfaces\Component)) {
                throw new \Exception('Component must implement \'Component\' interface',
                500);
            }
            $result->loadConfiguration($config);
        }

        return $result;
    }

    /**
     * Default components
     *
     * @return array
     */
    protected function requiredComponents()
    {
        return [
            'log' => [
                'handlers' => [
                    [
                        'class' => '\Monolog\Handler\RotatingFileHandler',
                        'params' => [
                            '../logs/error_log.log',
                            0,
                            \Monolog\Logger::DEBUG
                        ]
                    ]
                ]
            ]
        ];
    }
}