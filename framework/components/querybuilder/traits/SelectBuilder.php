<?php

namespace pwf\components\querybuilder\traits;

trait SelectBuilder
{
    /**
     * Select fields
     *
     * @var array
     */
    private $selectFields = [];

    /**
     * Condition
     *
     * @var array
     */
    private $where = [];

    /**
     * Limit
     *
     * @var int
     */
    private $limit;

    /**
     * Offset
     *
     * @var int
     */
    private $offset;

    /**
     * Having condition
     *
     * @var array
     */
    private $having = [];

    /**
     * Joins
     *
     * @var array
     */
    private $join = [];

    /**
     * Unions
     *
     * @var array
     */
    private $union = [];

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
     * Groupping
     *
     * @var array
     */
    private $group;

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
     *
     * @param mixed $group
     * @return $this
     */
    public function group($group)
    {
        $this->group = (array) $group;
        return $this;
    }

    /**
     * Get group
     *
     * @return array
     */
    public function getGroup()
    {
        return $this->group;
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

    /**
     * Set limit
     *
     * @param int $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set offset
     *
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Get offset
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set where condition
     *
     * @param mixed $condition
     * @return $this
     */
    public function where($condition)
    {
        $this->where = array_merge($this->where, (array) $condition);
        return $this;
    }

    /**
     * Get where
     *
     * @return array
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Set having condition
     *
     * @param mixed $condition
     * @return $this
     */
    public function having($condition)
    {
        $this->having = array_merge($this->having, (array) $condition);
        return $this;
    }

    /**
     * Get having
     *
     * @return array
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * Set select fields
     *
     * @param array $fields
     * @return $this
     */
    public function select(array $fields = array())
    {
        $this->selectFields = $fields;
        return $this;
    }

    /**
     * Get select fields
     *
     * @return array
     */
    public function getSelect()
    {
        return $this->selectFields;
    }

    /**
     * Add union
     *
     * @param \pwf\components\querybuilder\interfaces\QueryBuilder $query
     * @return $this
     */
    public function union(\pwf\components\querybuilder\interfaces\QueryBuilder $query)
    {
        $this->union[] = $query;
        return $this;
    }

    /**
     * Get union
     *
     * @return array
     */
    public function getUnion()
    {
        return $this->union;
    }

    /**
     * Join table
     *
     * @param string $table
     * @param mixed $condition
     * @param int $joinType
     * @return $this
     */
    public function join($table, $condition, $joinType = self::JOIN_LEFT)
    {
        $this->join[] = [
            'table' => $table,
            'condition' => $condition,
            'jointType' => $joinType
        ];
        return $this;
    }

    /**
     * Get join
     *
     * @return array
     */
    public function getJoin()
    {
        return $this->join;
    }
}