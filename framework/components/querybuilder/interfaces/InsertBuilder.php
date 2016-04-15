<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

interface InsertBuilder extends QueryBuilder
{

    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array;
}