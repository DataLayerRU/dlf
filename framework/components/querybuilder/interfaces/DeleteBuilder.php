<?php

namespace pwf\components\querybuilder\interfaces;

interface DeleteBuilder
{

    /**
     * Set table
     *
     * @param string $table
     */
    public function table($table);

    /**
     * Add condition
     *
     * @param mixed $condition
     */
    public function where($condition);
}