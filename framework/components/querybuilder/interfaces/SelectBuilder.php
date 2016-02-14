<?php

namespace pwf\components\querybuilder\interfaces;

interface SelectBuilder extends QueryBuilder
{
    /**
     * Left join
     */
    const JOIN_LEFT = 1;

    /**
     * Right join
     */
    const JOIN_RIGHT = 2;

    /**
     * Cross join
     */
    const JOIN_CROSS = 3;

    /**
     * Outer join
     */
    const JOIN_OUTER = 4;

    /**
     * Inner join
     */
    const JOIN_INNER = 5;

    /**
     * Set selected fields
     *
     * @param array $fields
     */
    public function select(array $fields);

    /**
     * Add condition
     *
     * @param mixed $condition
     */
    public function where($condition);

    /**
     * Set limit
     *
     * @param int $limit
     */
    public function limit($limit);

    /**
     * Set offset
     *
     * @param int $offset
     */
    public function offset($offset);

    /**
     * Set grouping
     *
     * @param mixed $group
     */
    public function group($group);

    /**
     * Add having condition
     *
     * @param mixed $condition
     */
    public function having($condition);

    /**
     * Join table
     *
     * @param string $table
     * @param mixed $condition
     * @param int $joinType
     */
    public function join($table, $condition, $joinType = self::JOIN_LEFT);

    /**
     * Union
     *
     * @param \pwf\components\querybuilder\interfaces\QueryBuilder $query
     */
    public function union(QueryBuilder $query);
}