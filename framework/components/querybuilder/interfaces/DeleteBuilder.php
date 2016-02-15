<?php

namespace pwf\components\querybuilder\interfaces;

interface DeleteBuilder extends QueryBuilder
{

    /**
     * Add condition
     *
     * @param mixed $condition
     */
    public function where($condition);
}