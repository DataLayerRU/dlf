<?php

namespace pwf\components\querybuilder\interfaces;

interface Generatable
{

    /**
     * Generate query
     *
     * @return string
     */
    public function generate();
}