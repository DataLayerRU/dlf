<?php

namespace pwf\components\dbconnection\abstraction;

abstract class Connection implements \pwf\components\dbconnection\interfaces\Connection
{
    /**
     * Connection string
     *
     * @var string
     */
    private $dsn;

    /**
     * Login
     *
     * @var string
     */
    private $login;

    /**
     * Password
     *
     * @var string
     */
    private $password;

    /**
     * Set connection string
     *
     * @param string $dsn
     * @return Connection
     */
    public function setDSN($dsn)
    {
        $this->dsn = $dsn;
        return $this;
    }

    /**
     * Get connection string
     *
     * @return string
     */
    public function getDSN()
    {
        return $this->dsn;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Connection
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Connection
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}