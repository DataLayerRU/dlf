<?php

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder extends Generatable
{

    /**
     * Set table name
     *
     * @param string $table
     * @return QueryBuilder
     */
    public function table($table);

    /**
     * Get params for query
     *
     * @return array
     */
    public function getParams();
}