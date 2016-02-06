<?php

namespace pwf\components\datamapper\interfaces;

interface Repository extends Getter
{

    /**
     * Set model
     *
     * @param \pwf\components\datamapper\interfaces\Model $model
     */
    public function save(Model $model);

    /**
     * Delete model
     *
     * @param \pwf\components\datamapper\interfaces\Model $model
     */
    public function delete(Model $model);
}