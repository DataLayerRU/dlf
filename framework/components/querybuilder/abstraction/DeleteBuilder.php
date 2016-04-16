<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\abstraction;

use pwf\components\querybuilder\interfaces\Conditional;
use pwf\components\querybuilder\interfaces\QueryBuilder;

abstract class DeleteBuilder implements Conditional, QueryBuilder
{

    /**
     * Build table part
     *
     * @return string
     */
    protected abstract function buildTable(): string;

    /**
     * Build where part
     *
     * @return string
     */
    protected abstract function buildWhere(): string;

    /**
     * Generate query
     *
     * @return string
     */
    public function generate(): string
    {
        $result = '';

        $table = $this->buildTable();
        $where = $this->buildWhere();

        $result .= 'DELETE FROM ' . $table;

        if ($where != '') {
            $result .= ' ' . $where;
        }

        return $result;
    }
}