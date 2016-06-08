<?php

namespace pwf\components\querybuilder\interfaces;

interface UpdateBuilder extends InsertBuilder {

    /**
     * Add condition
     *
     * @param mixed $condition
     */
    public function where(array $condition);
}
