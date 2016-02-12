<?php

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder extends Condition
{

    /**
     * Set table
     *
     * @param string $table
     */
    public function table($table);
}