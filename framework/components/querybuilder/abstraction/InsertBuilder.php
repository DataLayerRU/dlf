<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\abstraction;

abstract class InsertBuilder implements \pwf\components\querybuilder\interfaces\InsertBuilder
{

    /**
     * Build table part
     *
     * @return string
     */
    protected abstract function buildTable(): string;

    /**
     * Build fields part
     *
     * @return string
     */
    protected abstract function buildFields(): string;

    /**
     * Generate query
     *
     * @return string
     */
    public function generate(): string
    {
        $result = '';

        $table  = $this->buildTable();
        $fields = $this->buildFields();

        $result.='INSERT INTO '.$table.' '.$fields;

        return $result;
    }
}