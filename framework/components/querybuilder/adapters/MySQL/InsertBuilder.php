<?php

namespace pwf\components\querybuilder\adapters\MySQL;

class InsertBuilder extends \pwf\components\querybuilder\abstraction\InsertBuilder
{

    use \pwf\components\querybuilder\traits\QueryBuilder;

    /**
     * @inheritdoc
     */
    protected function buildFields()
    {
        $fields       = array_keys($this->getParams());
        $placeholders = $fields;
        array_walk($placeholders,
            function($value) {
            $value = ':'.$value;
        });
        return '('.implode(', ', $fields).') VALUES ('.implode(', ',
                $placeholders).')';
    }

    /**
     * @inheritdoc
     */
    protected function buildTable()
    {
        return $this->getTable();
    }
}