<?php

namespace pwf\components\activerecord\interfaces;

interface Model extends \pwf\components\datamapper\interfaces\Model
{
    /**
     * Save record
     *
     * @return bool
     */
    public function save();

    /**
     * Delete record
     *
     * @return bool
     */
    public function delete();

    /**
     * Get single model
     *
     * @param mixed $condition
     * @return \pwf\components\activerecord\interfaces\Model
     */
    public function getOne($condition);

    /**
     * Get all models
     *
     * @param mixed $condition
     * @param int $limit
     * @param int $offset
     * @return \pwf\components\activerecord\interfaces\Model[]
     */
    public function getAll($condition, $limit = null, $offset = null);
}