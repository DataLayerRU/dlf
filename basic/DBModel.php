<?php

namespace pwf\basic;

abstract class DBModel extends Model
{
    /**
     * Connection
     *
     * @var \pwf\basic\interfaces\Component
     */
    private $connection;

    public function __construct(\pwf\basic\interfaces\Component $connection,
                                $attributes = [])
    {
        parent::__construct($attributes);

        $this->setDB($connection);
    }

    /**
     * Set connection
     *
     * @param \pwf\basic\interfaces\Component $connection
     */
    public function setDB(\pwf\basic\interfaces\Component $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get connection
     *
     * @return \pwf\basic\interfaces\Component
     */
    public function getDB()
    {
        return $this->connection;
    }
}