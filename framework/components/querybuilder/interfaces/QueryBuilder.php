<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder extends Generatable
{

    /**
     * Set table name
     *
     * @param string $table
     * @return QueryBuilder
     */
    public function table(string $table): QueryBuilder;

    /**
     * Get params for query
     *
     * @return array
     */
    public function getParams(): array;
}