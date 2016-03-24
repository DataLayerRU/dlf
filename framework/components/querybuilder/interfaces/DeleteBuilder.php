<?php

namespace pwf\components\querybuilder\interfaces;

interface DeleteBuilder extends QueryBuilder
{

    /**
     * Add condition
     *
     * @param array $condition
     */
    public function where(array $condition);
}