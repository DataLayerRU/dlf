<?php

namespace pwf\components\activerecord\interfaces;

interface Model extends \pwf\components\datamapper\interfaces\Model, \pwf\components\datamapper\interfaces\Getter
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
}