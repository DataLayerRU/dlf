<?php

namespace dlf\components\datamapper\abstraction;

abstract class Repository implements \dlf\components\datamapper\interfaces\Repository
{
    private $connection;

    /**
     * Set connection object
     *
     * @param mixed $connection
     * @return \dlf\components\datamapper\abstraction\Repository
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