<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\traits;

use pwf\components\querybuilder\interfaces\QueryBuilder as IQueryBuilder;

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
     * @return IQueryBuilder
     */
    public function table(string $table): IQueryBuilder
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Get table
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Set primary key name
     *
     * @param string $name
     * @return IQueryBuilder
     */
    public function setPK(string $name): IQueryBuilder
    {
        $this->pkField = $name;
        return $this;
    }

    /**
     * Get primary key name
     *
     * @return string
     */
    public function getPK(): string
    {
        return $this->pkField;
    }
}