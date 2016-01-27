<?php

namespace pwf\components\datamapper\interfaces;

interface Repository
{

    /**
     * Get single model
     * 
     * @param mixed $condition
     * @return \pwf\components\datamapper\interfaces\Model
     */
    public function getOne($condition);

    /**
     * Get all models
     *
     * @param mixed $condition
     * @param int $limit
     * @param int $offset
     * @return \pwf\components\datamapper\interfaces\Model[]
     */
    public function getAll($condition, $limit = null, $offset = null);

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