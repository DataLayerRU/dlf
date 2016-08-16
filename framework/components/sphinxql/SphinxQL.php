<?php

namespace pwf\components\sphinxql;

use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Connection;

/**
 * SphinxQL query builder adapter
 */
class SphinxQL implements \pwf\basic\interfaces\Component
{
    /**
     * Connection config
     *
     * @var array
     */
    private $connectionConfig = [];

    /**
     * Sphinx connection
     *
     * @var \Foolz\SphinxQL\Connection
     */
    private $connection;

    public function init()
    {
        $conn = new Connection();
        $conn->setParams($this->getConfig());
        $this->setConnection($conn);
    }

    public function create()
    {
        return SphinxQL::create($this->getConnection());
    }

    /**
     * Set connection
     *
     * @param Connection $connection
     * @return \pwf\components\sphinxql\SphinxQL
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Get connection
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return \pwf\components\sphinxql\SphinxQL
     */
    public function loadConfiguration(array $config = array())
    {
        return $this->setConfig($config);
    }

    /**
     * Set config
     *
     * @param array $config
     * @return \pwf\components\sphinxql\SphinxQL
     */
    private function setConfig(array $config = [])
    {
        $this->connectionConfig = $config;
        return $this;
    }

    /**
     * Get configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->connectionConfig;
    }
}