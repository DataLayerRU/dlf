<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\traits;

use pwf\components\querybuilder\interfaces\SelectBuilder as ISelectBuilder;
use pwf\components\querybuilder\interfaces\QueryBuilder as IQueryBuilder;

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
     * @return ISelectBuilder
     */
    public function group(array $group): ISelectBuilder
    {
        $this->group = (array)$group;
        return $this;
    }

    /**
     * Get group
     *
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return ISelectBuilder
     */
    public function limit(int $limit): ISelectBuilder
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Set offset
     *
     * @param int $offset
     * @return ISelectBuilder
     */
    public function offset(int $offset): ISelectBuilder
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Get offset
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Set having condition
     *
     * @param mixed $condition
     * @return ISelectBuilder
     */
    public function having($condition): ISelectBuilder
    {
        $this->having = array_merge($this->having, (array)$condition);
        return $this;
    }

    /**
     * Get having
     *
     * @return array
     */
    public function getHaving(): array
    {
        return $this->having;
    }

    /**
     * Set select fields
     *
     * @param array $fields
     * @return ISelectBuilder
     */
    public function select(array $fields): ISelectBuilder
    {
        $this->selectFields = $fields;
        return $this;
    }

    /**
     * Get select fields
     *
     * @return array
     */
    public function getSelect(): array
    {
        return $this->selectFields;
    }

    /**
     * Add union
     *
     * @param IQueryBuilder $query
     * @return ISelectBuilder
     */
    public function union(IQueryBuilder $query): ISelectBuilder
    {
        $this->union[] = $query;
        return $this;
    }

    /**
     * Get union
     *
     * @return array
     */
    public function getUnion(): array
    {
        return $this->union;
    }

    /**
     * Join table
     *
     * @param string $table
     * @param mixed $condition
     * @param int $joinType
     * @return ISelectBuilder
     */
    public function join(string $table, $condition, int $joinType = self::JOIN_LEFT): ISelectBuilder
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
    public function getJoin(): array
    {
        return $this->join;
    }
}