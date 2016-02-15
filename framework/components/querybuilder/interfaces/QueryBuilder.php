<?php

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder extends Generatable
{

    /**
     * Set table
     *
     * @param string $table
     */
    public function table($table);
}