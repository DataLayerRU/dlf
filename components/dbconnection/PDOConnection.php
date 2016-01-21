<?php

namespace pwf\components\dbconnection;

use PDO;

class PDOConnection extends \pwf\components\dbconnection\abstraction\Connection implements \pwf\basic\interfaces\Component
{
    private $PDO;

    private $lastStatement;

    public function setPDO($pdo)
    {
        $this->PDO = $pdo;
    }

    public function getPDO()
    {
        return $this->PDO;
    }

    public function init()
    {
        $this->connect();
    }

    /**
     * Connection params
     *
     * @param array $params
     */
    public function connect($params = [])
    {
        $this->setPDO(new PDO($this->getDSN(), $this->getLogin(),
            $this->getPassword(), $params));
    }

    /**
     * Disconnect from DB server
     */
    public function disconnect()
    {
        unset($this->PDO);
        $this->PDO = null;
    }

    /**
     * Load configuration
     *
     * @param array $config
     */
    public function loadConfiguration($config = array())
    {
        if (isset($config['login'])) {
            $this->setLogin($config['login']);
        }
        if (isset($config['password'])) {
            $this->setPassword($config['password']);
        }
        if (isset($config['dsn'])) {
            $this->setDSN($config['dsn']);
        }
    }

    /**
     * Execute query
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function exec($query, $params = [])
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        $this->lastStatement->execute($params);
        return $this->lastStatement;
    }

    /**
     * Execute query
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function query($query, $params = [])
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        $this->lastStatement->execute($params);
        return $this->lastStatement;
    }

    /**
     * Get last insert id
     *
     * @return string
     */
    public function insertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}