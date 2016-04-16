<?php

declare(strict_types = 1);

namespace pwf\components\observer\interfaces;

interface Observer
{

    /**
     * Handle notification
     *
     * @param \pwf\components\observer\interfaces\Subject $subject
     * @return Observer
     */
    public function update(Subject $subject): Observer;
}