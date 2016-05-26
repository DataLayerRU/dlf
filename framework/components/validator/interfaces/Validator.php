<?php

namespace pwf\components\validator\interfaces;

interface Validator
{

    /**
     * Validate params
     *
     * @param mixed $data
     * @return bool
     */
    public function validate($data);
}