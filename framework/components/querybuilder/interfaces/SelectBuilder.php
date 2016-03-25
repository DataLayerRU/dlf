<?php

namespace pwf\components\querybuilder\interfaces;

/**
 * @method SelectBuilder table(string $table) Set table name
 */
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
     * @return SelectBuilder
     */
    public function select(array $fields);

    /**
     * Add condition
     *
     * @param array $condition
     * @return SelectBuilder
     */
    public function where(array $condition);

    /**
     * Set limit
     *
     * @param int $limit
     * @return SelectBuilder
     */
    public function limit($limit);

    /**
     * Set offset
     *
     * @param int $offset
     * @return SelectBuilder
     */
    public function offset($offset);

    /**
     * Set grouping
     *
     * @param array $group
     * @return SelectBuilder
     */
    public function group($group);

    /**
     * Add having condition
     *
     * @param array $condition
     * @return SelectBuilder
     */
    public function having($condition);

    /**
     * Join table
     *
     * @param string $table
     * @param mixed $condition
     * @param int $joinType
     * @return SelectBuilder
     */
    public function join($table, $condition, $joinType = self::JOIN_LEFT);

    /**
     * Union
     *
     * @param \pwf\components\querybuilder\interfaces\QueryBuilder $query
     * @return SelectBuilder
     */
    public function union(QueryBuilder $query);
}