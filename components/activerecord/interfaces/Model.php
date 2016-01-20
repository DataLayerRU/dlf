<?php

namespace dlf\components\activerecord\interfaces;

interface Model extends \dlf\components\datamapper\interfaces\Model
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
     * @return \dlf\components\activerecord\interfaces\Model
     */
    public function getOne($condition);

    /**
     * Get all models
     *
     * @param mixed $condition
     * @param int $limit
     * @param int $offset
     * @return \dlf\components\activerecord\interfaces\Model[]
     */
    public function getAll($condition, $limit = null, $offset = null);
}