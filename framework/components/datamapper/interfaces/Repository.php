<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\interfaces;

interface Repository extends Getter
{

    /**
     * Set model
     *
     * @param \pwf\components\datamapper\interfaces\Model $model
     * @return bool
     */
    public function save(Model $model): bool;

    /**
     * Delete model
     *
     * @param \pwf\components\datamapper\interfaces\Model $model
     * @return bool
     */
    public function delete(Model $model): bool;
}