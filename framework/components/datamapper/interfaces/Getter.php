<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\interfaces;

interface Getter
{

    /**
     * Get single model
     *
     * @return Getter
     */
    public function getOne(): Getter;

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