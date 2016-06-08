<?php

namespace pwf\components\querybuilder\adapters\PostgreSQL;

class SelectBuilder extends \pwf\components\querybuilder\adapters\MySQL\SelectBuilder
{

    /**
     * @inheritdoc
     */
    protected function buildLimit()
    {
        $result = '';

        $offset = $this->getOffset();

        if (($limit = $this->getLimit()) > 0) {
            $result.='LIMIT '.$limit;
        }
        if (($offset = $this->getOffset()) > 0) {
            $result.=' ';
            $result.='OFFSET '.$offset;
        }

        return $result;
    }
}