<?php

namespace pwf\components\datamapper\interfaces;

interface Getter
{
    /**
     * Get single model
     *
     * @param mixed $condition
     * @return \pwf\components\datamapper\interfaces\Getter
     */
    public function getOne($condition);

    /**
     * Get all models
     *
     * @param mixed $condition
     * @param int $limit
     * @param int $offset
     * @return \pwf\components\datamapper\interfaces\Getter[]
     */
    public function getAll($condition, $limit = null, $offset = null);
}