<?php

namespace pwf\components\dbconnection;

use PDO;

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
     * @var PdoStatement
     */
    private $lastStatement;

    /**
     * Set PDO object
     *
     * @param \PDO $pdo
     * @return \pwf\components\dbconnection\PDOConnection
     */
    public function setPDO($pdo)
    {
        $this->PDO = $pdo;
        return $this;
    }

    /**
     * Get PDO object
     *
     * @return \PDO
     */
    public function getPDO()
    {
        if ($this->PDO === null) {
            $this->connect();
        }
        return $this->PDO;
    }

    /**
     * Init connection
     *
     * @return \pwf\components\dbconnection\PDOConnection
     */
    public function init()
    {
        return $this;
    }

    /**
     * Connection params
     *
     * @param array $params
     * @return $this
     */
    public function connect(array $params = [])
    {
        $this->setPDO(new PDO($this->getDSN(), $this->getLogin(),
            $this->getPassword(), $params));
        return $this;
    }

    /**
     * Disconnect from DB server
     *
     * @return \pwf\components\dbconnection\PDOConnection
     */
    public function disconnect()
    {
        unset($this->PDO);
        $this->PDO = null;
        return $this;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return \pwf\components\dbconnection\PDOConnection
     */
    public function loadConfiguration(array $config = [])
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
     * @return PDOStatement
     */
    public function exec($query, array $params = [])
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        $res                 = $this->lastStatement->execute($this->prepareParams($params));
        $errors              = $this->lastStatement->errorInfo();
        return $res;
    }

    /**
     * Execute query
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function query($query, array $params = [])
    {
        $this->lastStatement = $this->getPDO()->prepare($query);
        $this->lastStatement->execute($this->prepareParams($params));
        return $this->lastStatement;
    }

    /**
     * Get last insert id
     *
     * @param string $sequenceName
     * @return string
     */
    public function insertId($sequenceName = null)
    {
        return $this->getPDO()->lastInsertId($sequenceName);
    }

    /**
     * Prepare params
     *
     * @param array $params
     * @return array
     */
    protected function prepareParams(array $params)
    {
        $result = $params;

        foreach ($result as $key => $val) {
            if (is_bool($val)) {
                $result[$key] = $val ? 1 : 0;
            }
        }

        return $result;
    }

    /**
     * Begin transaction
     *
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->getPDO()->beginTransaction();
    }

    /**
     * Commit
     *
     * @return bool
     */
    public function commitTransaction()
    {
        return $this->getPDO()->commit();
    }

    /**
     * Rollback
     *
     * @return bool
     */
    public function rollbackTransaction()
    {
        return $this->getPDO()->rollBack();
    }
}