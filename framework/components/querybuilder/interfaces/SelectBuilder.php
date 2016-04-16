<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

/**
 * @method SelectBuilder table(string $table) Set table name
 */
interface SelectBuilder extends QueryBuilder, Conditional
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
    public function select(array $fields): SelectBuilder;

    /**
     * Set limit
     *
     * @param int $limit
     * @return SelectBuilder
     */
    public function limit(int $limit): SelectBuilder;

    /**
     * Set offset
     *
     * @param int $offset
     * @return SelectBuilder
     */
    public function offset(int $offset): SelectBuilder;

    /**
     * Set grouping
     *
     * @param array $group
     * @return SelectBuilder
     */
    public function group(array $group): SelectBuilder;

    /**
     * Add having condition
     *
     * @param mixed $condition
     * @return SelectBuilder
     */
    public function having($condition): SelectBuilder;

    /**
     * Join table
     *
     * @param string $table
     * @param mixed $condition
     * @param int $joinType
     * @return SelectBuilder
     */
    public function join(string $table, $condition, int $joinType = self::JOIN_LEFT): SelectBuilder;

    /**
     * Union
     *
     * @param \pwf\components\querybuilder\interfaces\QueryBuilder $query
     * @return SelectBuilder
     */
    public function union(QueryBuilder $query): SelectBuilder;
}