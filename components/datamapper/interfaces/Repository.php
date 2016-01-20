<?php

namespace dlf\components\datamapper\interfaces;

interface Repository
{

    /**
     * Get single model
     * 
     * @param mixed $condition
     * @return \dlf\components\datamapper\interfaces\Model
     */
    public function getOne($condition);

    /**
     * Get all models
     *
     * @param mixed $condition
     * @param int $limit
     * @param int $offset
     * @return \dlf\components\datamapper\interfaces\Model[]
     */
    public function getAll($condition, $limit = null, $offset = null);

    /**
     * Set model
     *
     * @param \dlf\components\datamapper\interfaces\Model $model
     */
    public function save(Model $model);

    /**
     * Delete model
     *
     * @param \dlf\components\datamapper\interfaces\Model $model
     */
    public function delete(Model $model);
}