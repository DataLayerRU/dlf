<?php

namespace pwf\components\querybuilder\abstraction;

trait QueryBuilder
{
    /**
     * Params
     *
     * @var array
     */
    private $params = [];

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

    /**
     * Set params
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Add param
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}