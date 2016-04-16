<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\adapters\PostgreSQL;

class SelectBuilder extends \pwf\components\querybuilder\adapters\MySQL\SelectBuilder
{

    /**
     * @inheritdoc
     */
    protected function buildLimit(): string
    {
        $result = '';

        $offset = $this->getOffset();

        if (($limit = $this->getLimit()) > 0) {
            $result .= 'LIMIT ' . $limit;
        }
        if (($offset = $this->getOffset()) > 0) {
            $result .= ' ';
            $result .= 'OFFSET ' . $offset;
        }

        return $result;
    }
}