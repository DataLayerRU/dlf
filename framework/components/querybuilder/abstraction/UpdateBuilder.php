<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\abstraction;

abstract class UpdateBuilder extends InsertBuilder implements \pwf\components\querybuilder\interfaces\InsertBuilder
{

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

        $table  = $this->buildTable();
        $fields = $this->buildFields();
        $where  = $this->buildWhere();

        $result.='UPDATE '.$table.' SET '.$fields;

        if ($where != '') {
            $result.=' '.$where;
        }

        return $result;
    }
}