<?php

declare(strict_types = 1);

namespace pwf\basic;

use Monolog\Logger;
use pwf\web\Request;
use pwf\web\Response;
use pwf\basic\interfaces\Component as IComponent;
use pwf\exception\interfaces\HttpException;

class Application extends Object implements \pwf\basic\interfaces\Application
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
     * @var Request
     */
    private $request;

    /**
     * Response
     *
     * @var Response
     */
    private $response;

    public function __construct(array $config = [])
    {
        $this->request = new Request($_REQUEST);
        $this->response = new Response();
        $this->setConfiguration($config);


        static::$instance = $this;
    }

    /**
     * Get current request
     *
     * @return \pwf\web\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get current response
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Set configuration
     *
     * @param array $config
     * @return Application
     */
    public function setConfiguration(array $config = []): Application
    {
        $this->configuration = array_merge($this->requiredComponents(), $config);
        return $this;
    }

    /**
     * Get configuration
     *
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * Append configuration
     *
     * @param array $config
     * @return Application
     */
    public function appendConfiguration(array $config): Application
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
    public function getComponentConfig(string $componentName): array
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

            $path = $this->request->getPath();

            static::log('Request', ['path' => $path], Logger::INFO);

            $callback = $this->prepareCallback(RouteHandler::getHandler($path));

            if (is_array($callback) && $callback[0] instanceof \pwf\basic\interfaces\Controller) {
                $callback[0]->setRequest($this->getRequest())->setResponse($this->getResponse());
            }

            static::log('Call callback', [], Logger::INFO);

            $this->response->setBody(\pwf\helpers\SystemHelpers::call($callback,
                function ($paramName) {
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
            static::log($ex->getContent(), [], Logger::ERROR);
            $this->getComponent('log')->addError($ex->getMessage());
        } catch (\Exception $ex) {
            $this->response->setHeaders([
                'HTTP/1.1 500 Internal Server Error'
            ]);
            $this->response->setBody('<h2>Handled exception</h2>'
                . '<h3>' . $ex->getMessage() . '</h3>'
                . '<pre>'
                . $ex->getTraceAsString()
                . '</pre>');
            static::log($ex->getMessage(), [], Logger::ERROR);
        }
        static::log('Send response', [], Logger::INFO);
        $this->response->send();
    }

    /**
     * Force component loading
     *
     * @return \pwf\basic\Application
     */
    protected function forceComponentLoading(): Application
    {
        $config = $this->getConfiguration();
        foreach ($config as $key => $params) {
            if (isset($params['class']) && isset($params['force']) && $params['force']) {
                $this->getComponent($key);
            }
        }
        return $this;
    }

    /**
     * Get component by name
     *
     * @param string $name
     * @return IComponent
     */
    public function getComponent(string $name): IComponent
    {
        if (!isset($this->componentCache[$name]) && ($this->componentCache[$name]
                = $this->createComponent($name)) !== null
        ) {
            $this->componentCache[$name]->init();
        }

        return $this->componentCache[$name];
    }

    /**
     * Create component/module by name
     *
     * @param string $name
     * @return IComponent
     * @throws \Exception
     */
    protected function createComponent(string $name): IComponent
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
    protected function requiredComponents(): array
    {
        return [
            'log' => [
                'class' => '\pwf\components\monologadapter\MonologLogger',
                'handlers' => [
                    [
                        'class' => '\Monolog\Handler\RotatingFileHandler',
                        'force' => true,
                        'params' => [
                            '../logs/error_log.log',
                            0,
                            Logger::DEBUG
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Add message to log
     *
     * @param string $message
     * @param array $context
     * @param int $level
     * @return boolean
     */
    public static function log(
        $message,
        array $context = [],
        $level = Logger::DEBUG
    ) {
        return self::$instance->getComponent('log')->log($level, $message,
            $context);
    }

    /**
     * Get field
     *
     * @param string $name
     * @return mixed|Component
     * @throws \Exception
     */
    public function __get(string $name)
    {
        if (($component = $this->getComponent($name)) !== null) {
            return $component;
        }

        return parent::__get($name);
    }
}