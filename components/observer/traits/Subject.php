<?php

namespace pwf\components\observer\traits;

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
     * @param mixed $type
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @return $this
     */
    public function attach($type, Observer $observer)
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
     * @param mixed $type
     * @param \pwf\components\observer\interfaces\Observer $observer
     * @return $this
     */
    public function detach($type, Observer $observer)
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
    public function notify($type)
    {
        if (isset($this->observers[$type])) {
            foreach ($this->observers[$type] as $obs) {
                $this->observers[$type]->update($this);
            }
        }
        return $this;
    }
}