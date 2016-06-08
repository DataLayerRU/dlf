<?php

namespace pwf\components\querybuilder\traits;

trait QueryBuilder
{
    /**
     * Table
     *
     * @var string
     */
    private $table;

    /**
     * Primary key name
     *
     * @var string
     */
    private $pkField;

    /**
     * Set table
     *
     * @param string $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Get table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set primary key name
     *
     * @param string $name
     * @return $this
     */
    public function setPK($name)
    {
        $this->pkField = $name;
        return $this;
    }

    /**
     * Get primary key name
     *
     * @return string
     */
    public function getPK()
    {
        return $this->pkField;
    }
}