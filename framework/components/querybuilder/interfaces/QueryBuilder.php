<?php

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder extends ConditionBuilder
{

    /**
     * Set table
     *
     * @param string $table
     */
    public function table($table);
}