<?php

namespace dlf\components\activerecord\abstraction;

abstract class Model extends \dlf\components\datamapper\abstraction\Model
{
    /**
     * Connection
     *
     * @var mixed
     */
    private $connection;

    /**
     * Set connection
     *
     * @param mixed $connection
     * @return \dlf\components\activerecord\abstraction\Model
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