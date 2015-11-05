<?php

namespace dlf\basic;

abstract class DBModel extends Model
{
    /**
     * Connection
     *
     * @var \dlf\basic\interfaces\Component
     */
    private $connection;

    public function __construct(\dlf\basic\interfaces\Component $connection,
                                $attributes = [])
    {
        parent::__construct($attributes);

        $this->setDB($connection);
    }

    /**
     * Set connection
     *
     * @param \dlf\basic\interfaces\Component $connection
     */
    public function setDB(\dlf\basic\interfaces\Component $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get connection
     *
     * @return \dlf\basic\interfaces\Component
     */
    public function getDB()
    {
        return $this->connection;
    }
}