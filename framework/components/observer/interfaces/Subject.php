<?php

namespace pwf\components\observer\interfaces;

interface Subject
{

    /**
     * Attach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param string $type
     */
    public function attach(Observer $observer, $type = 'default');

    /**
     * Detach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param string $type
     */
    public function detach(Observer $observer, $type = 'default');

    /**
     * Notify observers by type
     *
     * @param string $type
     */
    public function notify($type = 'default');
}