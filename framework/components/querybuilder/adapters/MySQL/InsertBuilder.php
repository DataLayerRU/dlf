<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\adapters\MySQL;

class InsertBuilder extends \pwf\components\querybuilder\abstraction\InsertBuilder
{

    use \pwf\components\querybuilder\traits\QueryBuilder,
        \pwf\components\querybuilder\traits\Parameterized;

    /**
     * @inheritdoc
     */
    protected function buildFields(): string
    {
        $fields       = array_keys($this->getParams());
        $placeholders = $fields;
        array_walk($placeholders,
            function(&$value) {
            $value = ':'.$value;
        });
        return '('.implode(', ', $fields).') VALUES ('.implode(', ',
                $placeholders).')';
    }

    /**
     * @inheritdoc
     */
    protected function buildTable(): string
    {
        return $this->getTable();
    }
}