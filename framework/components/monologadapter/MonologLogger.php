<?php

namespace pwf\components\monologadapter;

use Monolog\Logger;

/**
 * Monolog adapter
 * 
 * https://github.com/Seldaek/monolog
 */
class MonologLogger extends Logger implements \pwf\basic\interfaces\Component
{
    /**
     * Handlers
     *
     * @var array
     */
    private $logHandlers = [];

    public function __construct()
    {
        parent::__construct(uniqid('logger_'));
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $handlers = $this->getHandlers();
        foreach ($handlers as $handler) {
            if (!isset($handler['class'])) {
                throw new \Exception(__CLASS__.': \'class\' is required for handler');
            }
            $params = isset($handler['params']) ? $handler['params'] : [];
            $this->pushHandler(\pwf\helpers\SystemHelpers::constructObject($handler['class'],
                    $params));
        }
        return $this;
    }

    /**
     * Set configuration
     *
     * @param array $config
     * @return \pwf\components\monologadapter\MonologAdapter
     */
    public function loadConfiguration(array $config = array())
    {
        $this->setHandlers($config['handlers']);
        return $this;
    }

    /**
     * Set handler list
     *
     * @param array $handlers
     * @return \pwf\components\monologadapter\MonologAdapter
     */
    public function setHandlers(array $handlers)
    {
        $this->logHandlers = $handlers;
        return $this;
    }

    /**
     * Get handlers
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->logHandlers;
    }
}