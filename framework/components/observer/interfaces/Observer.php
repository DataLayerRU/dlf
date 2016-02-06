<?php

namespace pwf\components\observer\interfaces;

interface Observer
{

    /**
     * Handle notification
     *
     * @param \pwf\components\observer\interfaces\Subject $subject
     */
    public function update(Subject $subject);
}