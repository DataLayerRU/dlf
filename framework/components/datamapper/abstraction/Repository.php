<?php

namespace pwf\components\datamapper\abstraction;

abstract class Repository implements \pwf\components\datamapper\interfaces\Repository
{
    private $connection;

    /**
     * Set connection object
     *
     * @param mixed $connection
     * @return \pwf\components\datamapper\abstraction\Repository
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Get connection
     *
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }
}