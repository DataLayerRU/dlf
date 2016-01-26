<?php

namespace pwf\components\observer\interfaces;

interface Subject
{

    /**
     * Attach observer
     *
     * @param mixed $type
     * @param \pwf\components\observer\interfaces\Observer $observer
     */
    public function attach($type, Observer $observer);

    /**
     * Detach observer
     *
     * @param mixed $type
     * @param \pwf\components\observer\interfaces\Observer $observer
     */
    public function detach($type, Observer $observer);

    /**
     * Notify observers by type
     *
     * @param mixed $type
     */
    public function notify($type);
}