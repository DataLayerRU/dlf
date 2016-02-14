<?php

namespace pwf\components\querybuilder\traits;

trait SelectBuilder
{

    use QueryBuilder;
    /**
     * Select fields
     *
     * @var array
     */
    private $selectFields = ['*'];

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
     * Groupping
     *
     * @var array
     */
    private $group;

    /**
     *
     * @param mixed $group
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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
     * Set limit
     *
     * @param int $limit
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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
     * Set having condition
     *
     * @param mixed $condition
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
     */
    public function select(array $fields)
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
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
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