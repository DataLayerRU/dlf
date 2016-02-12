<?php

namespace pwf\components\querybuilder\abstraction;

abstract class InsertBuilder implements \pwf\components\querybuilder\interfaces\InsertBuilder
{

    /**
     * Build table part
     *
     * @return string
     */
    protected abstract function buildTable();

    /**
     * Build fields part
     *
     * @return string
     */
    protected abstract function buildFields();

    /**
     * Generate query
     *
     * @return string
     */
    public function generate()
    {
        $result = '';

        $table  = $this->buildTable();
        $fields = $this->buildFields();

        $result.='UPDATE '.$table.' SET '.$fields.

        $result.='INSERT INTO '.$table.' ('.$fields.') VALUES ('.$values.')';

        return $result;
    }
}