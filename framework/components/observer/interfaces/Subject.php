<?php

declare(strict_types = 1);

namespace pwf\components\observer\interfaces;

interface Subject
{

    /**
     * Attach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param string $type
     * @return Subject
     */
    public function attach(Observer $observer, string $type = 'default'): Subject;

    /**
     * Detach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param string $type
     * @return Subject
     */
    public function detach(Observer $observer, string $type = 'default'): Subject;

    /**
     * Notify observers by type
     *
     * @param string $type
     * @return Subject
     */
    public function notify(string $type = 'default'): Subject;
}