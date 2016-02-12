<?php

namespace pwf\components\querybuilder\interfaces;

interface QueryBuilder
{

    /**
     * Set table
     *
     * @param string $table
     */
    public function table($table);

    /**
     * Generate query
     *
     * @return string
     */
    public function generate();

    /**
     * Set params
     *
     * @param array $params
     */
    public function setParams(array $params = []);
}