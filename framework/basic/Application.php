<?php

namespace pwf\basic;

use pwf\web\Request;
use pwf\web\Response;
use pwf\helpers\SystemHelpers;
use pwf\basic\interfaces\Plugin;
use pwf\exception\interfaces\HttpException;

class Application implements \pwf\basic\interfaces\Application, \pwf\components\eventhandler\interfaces\EventHandler
{

    use \pwf\components\eventhandler\traits\EventTrait;
    //
    //<editor-fold desc="Variables" defaultstate="collapsed">
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
     * PlugIn list
     *
     * @var array
     */
    private $plugins = [];

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

    //</editor-fold>

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
     * Get configuration parameter
     *
     * @param string $name
     * @return mixed
     */
    public function getConfigParam($name)
    {
        $result = null;
        $config = $this->getConfiguration();
        if (isset($config[$name])) {
            $result = $config[$name];
        }
        return $result;
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
        if (isset($config[self::COMPONENT_CONFIG_BLOCK][$componentName])) {
            $result = $config[self::COMPONENT_CONFIG_BLOCK][$componentName];
        }
        return $result;
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            $this->trigger(self::EVENT_APPLICATION_RUN);

            $this->forceComponentLoading();

            $callback = $this->prepareCallback(RouteHandler::getHandler($this->request->getPath()));

            $this->trigger(self::EVENT_BEFORE_HANDLER);

            if (is_array($callback) && $callback[0] instanceof \pwf\basic\interfaces\Controller) {
                $callback[0]->setRequest($this->getRequest())->setResponse($this->getResponse());
            }

            $this->response->setBody($this->runController($callback));
            $this->trigger(self::EVENT_AFTER_HANDLER);
        } catch (HttpException $ex) {
            $this->response->setHeaders($ex->getHeaders());
            $this->response->setBody(
                $this->runController($this->getConfigParam('error'),
                    ['error' => $ex])
            );
        } catch (\Exception $ex) {
            $this->response->setHeaders([
                'HTTP/1.1 500 Internal Server Error'
            ]);
            $this->response->setBody(
                $this->runController($this->getConfigParam('error'),
                    ['error' => $ex])
            );
        }
        $this->response->send();
        $this->trigger(self::EVENT_APPLICATION_FINISH);
    }

    /**
     * Run by handler name
     *
     * @param Closure|string|Callable $handler
     * @param array $params
     * @return string
     */
    public function runController($handler, array $params = [])
    {
        return SystemHelpers::call(
                $this->prepareCallback($handler),
                function($paramName) use ($params) {
                if (($component = $this->getComponent($paramName)) !== null) {
                    return $component;
                }
                if (isset($_GET[$paramName])) {
                    return $_GET[$paramName];
                }
                if (isset($_POST[$paramName])) {
                    return $_POST[$paramName];
                }
                if (isset($params[$paramName])) {
                    return $params[$paramName];
                }
            });
    }

    /**
     * Force component loading
     *
     * @return \pwf\basic\Application
     */
    protected function forceComponentLoading()
    {
        $config = $this->getConfiguration();
        foreach ($config[self::COMPONENT_CONFIG_BLOCK] as $key => $params) {
            if (isset($params['class']) && isset($params['force'])) {
                $component = $this->getComponent($key);
                if ($component instanceof Plugin) {
                    $this->attachPlugin($key, $component);
                }
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
     * Check is component exists
     *
     * @param string $name
     * @return bool
     */
    public function componentExists($name)
    {
        return isset($this->getConfiguration()[self::COMPONENT_CONFIG_BLOCK][$name]);
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

    public function __get($name)
    {
        if ($this->componentExists($name)) {
            return $this->getComponent($name);
        }
        return null;
    }

    /**
     * Attach plugin to application
     *
     * @param string $name
     * @param Plugin $plugin
     * @return \pwf\basic\Application
     */
    public function attachPlugin($name, Plugin $plugin)
    {
        $plugin->register($this);
        $this->plugins[$name] = $plugin;
        return $this;
    }

    /**
     * Remove plugin
     *
     * @param string $name
     * @return \pwf\basic\Application
     */
    public function detachPlugin($name)
    {
        $this->plugins[$name]->unregister();
        unset($this->plugins[$name]);
        return $this;
    }
}