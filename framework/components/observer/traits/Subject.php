<?php

namespace pwf\components\observer\traits;

use \pwf\components\observer\interfaces\Observer;

trait Subject
{
    /**
     * Observers grouped by type
     *
     * @var array
     */
    private $observers = [];

    /**
     * Attach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param mixed $type
     * @return $this
     */
    public function attach(Observer $observer, $type = 'default')
    {
        if (!isset($this->observers[$type])) {
            $this->observers[$type] = [];
        }
        $this->observers[$type][] = $observer;
        return $this;
    }

    /**
     * Detach observer
     *
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @param mixed $type
     * @return $this
     */
    public function detach(Observer $observer, $type = 'default')
    {
        if (isset($this->observers[$type])) {
            foreach ($this->observers[$type] as $key => $obs) {
                if ($obs === $observer) {
                    unset($this->observers[$type][$key]);
                }
            }
        }
        return $this;
    }

    /**
     * Notify observers by type
     *
     * @param mixed $type
     */
    public function notify($type = 'default')
    {
        if (isset($this->observers[$type])) {
            foreach ($this->observers[$type] as $obs) {
                $obs->update($this);
            }
        }
        return $this;
    }
}