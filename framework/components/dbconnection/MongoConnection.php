<?php

namespace pwf\components\dbconnection;

class MongoConnection extends \pwf\components\dbconnection\abstraction\Connection implements \pwf\basic\interfaces\Component
{
    /**
     * Connection to MongoDB
     *
     * @var \MongoDB\Database
     */
    private $connection;

    /**
     * DB name
     *
     * @var string
     */
    private $name;

    /**
     * Connect to db
     *
     * @param array $params
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function connect(array $params = [])
    {
        $this->setConnection((new \MongoDB\Client($params['dsn']))->{$this->getName()});
        return $this;
    }

    /**
     * Disconnect
     *
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function disconnect()
    {
        $this->connection = null;
        return $this;
    }

    /**
     * Exec command
     *
     * @param array $query
     * @param array $params
     * @return Cursor
     */
    public function exec($query, array $params = [])
    {
        return $this->getConnection()->command($query, $params);
    }

    /**
     * Initialization
     *
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function init()
    {
        return $this;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function loadConfiguration(array $config = [])
    {
        if (isset($config['dsn'])) {
            $this->setDSN($config['dsn']);
        }
        if (isset($config['name'])) {
            $this->setName($config['name']);
        }
        return $this;
    }

    /**
     * Exec command
     *
     * @param array $query
     * @param array $params
     * @return Cursor
     */
    public function query($query, array $params = [])
    {
        return $this->find($query);
    }

    /**
     * Set connection
     *
     * @param \MongoDB\Database $connection
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function setConnection(\MongoDB\Client $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Get connection
     *
     * @return \MongoDB\Database
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return \pwf\components\dbconnection\MongoConnection
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}