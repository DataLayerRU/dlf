<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

interface Generatable
{

    /**
     * Generate query
     *
     * @return string
     */
    public function generate(): string;
}