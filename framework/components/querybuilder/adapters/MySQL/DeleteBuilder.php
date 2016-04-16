<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\adapters\MySQL;

use pwf\components\querybuilder\traits\{
    QueryBuilder, Conditional, Parameterized
};

class DeleteBuilder extends \pwf\components\querybuilder\abstraction\DeleteBuilder
{

    use QueryBuilder, Conditional, Parameterized;

    /**
     * @inheritdoc
     */
    protected function buildWhere(): string
    {
        $result = '';

        $where = $this->getConditionBuilder()
            ->setCondition($this->getWhere())
            ->generate();

        if ($where != '') {
            $result .= 'WHERE ' . $where;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildTable(): string
    {
        return $this->getTable();
    }
}