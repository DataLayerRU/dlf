<?php

declare(strict_types = 1);

namespace pwf\components\dbconnection;

use PDO;
use pwf\basic\interfaces\Component;
use pwf\components\dbconnection\interfaces\Connection;

class PDOConnection extends \pwf\components\dbconnection\abstraction\Connection implements \pwf\basic\interfaces\Component
{
    /**
     * PDO object
     *
     * @var \PDO
     */
    private $PDO;

    /**
     * Last PDO statement
     *
     * @var \PDOStatement
     */
    private $lastStatement;

    /**
     * Set PDO object
     *
     * @param \PDO $pdo
     * @return \pwf\components\dbconnection\PDOConnection
     */
    public function setPDO(\PDO $pdo): PDOConnection
    {
        $this->PDO = $pdo;
        return $this;
    }

    /**
     * Get PDO object
     *
     * @return \PDO
     */
    public function getPDO(): \PDO
    {
        if ($this->PDO === null) {
            $this->connect();
        }
        return $this->PDO;
    }

    /**
     * Init connection
     *
     * @return Component
     */
    public function init(): Component
    {
        return $this;
    }

    /**
     * Connection params
     *
     * @param array $params
     * @return Connection
     */
    public function connect(array $params = []): Connection
    {
        $this->setPDO(new PDO($this->getDSN(), $this->getLogin(),
            $this->getPassword(), $params));
        return $this;
    }

    /**
     * Disconnect from DB server
     *
     * @return Connection
     */
    public function disconnect(): Connection
    {
        unset($this->PDO);
        $this->PDO = null;
        return $this;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return Component
     */
    public function loadConfiguration(array $config = []): Component
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
        return $this;
    }

    /**
     * Execute query
     *
     * @param string $query
     * @param array $params
     * @return \PDOStatement
     */
    public function exec(string $query, array $params = []): \PDOStatement
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        return $this->lastStatement->execute($params);
    }

    /**
     * Execute query
     *
     * @param string $query
     * @param array $params
     * @return \PDOStatement
     */
    public function query(string $query, array $params = []): \PDOStatement
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        $this->lastStatement->execute($params);
        return $this->lastStatement;
    }

    /**
     * Get last insert id
     *
     * @return int
     */
    public function insertId(): int
    {
        return (int)$this->getPDO()->lastInsertId();
    }
}