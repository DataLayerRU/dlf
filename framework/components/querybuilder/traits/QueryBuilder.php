<?php

namespace pwf\components\querybuilder\traits;

trait QueryBuilder
{

    use ConditionBuilder;
    /**
     * Table
     *
     * @var string
     */
    private $table;

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
}