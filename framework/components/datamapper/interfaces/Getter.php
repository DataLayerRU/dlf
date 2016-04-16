<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\interfaces;

interface Getter
{

    /**
     * Get single model
     *
     * @return array
     */
    public function getOne(): array;

    /**
     * Get all models
     *
     * @return \pwf\components\datamapper\interfaces\Getter[]
     */
    public function getAll(): array;

    /**
     * Count objects
     *
     * @return int
     */
    public function count(): int;
}