<?php

declare(strict_types = 1);

namespace pwf\components\activerecord\interfaces;

interface Model extends \pwf\components\datamapper\interfaces\Model, \pwf\components\datamapper\interfaces\Getter
{

    /**
     * Save record
     *
     * @return bool
     */
    public function save(): bool;

    /**
     * Delete record
     *
     * @return bool
     */
    public function delete(): bool;
}