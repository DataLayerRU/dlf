<?php

namespace pwf\components\datamapper\interfaces;

interface Getter
{

    /**
     * Get single model
     *
     * @return \pwf\components\datamapper\interfaces\Getter
     */
    public function getOne();

    /**
     * Get all models
     *
     * @return \pwf\components\datamapper\interfaces\Getter[]
     */
    public function getAll();

    /**
     * Count objects
     * 
     * @return int
     */
    public function count();
}