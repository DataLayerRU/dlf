<?php

declare(strict_types = 1);

namespace pwf\components\observer\traits;

use \pwf\components\observer\interfaces\Observer;
use \pwf\components\observer\interfaces\Subject as ISubject;

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
     * @param string $type
     * @return ISubject
     */
    public function attach(Observer $observer, string $type = 'default'): ISubject
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
     * @param string $type
     * @return ISubject
     */
    public function detach(Observer $observer, string $type = 'default'): ISubject
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
     * @param string $type
     * @return ISubject
     */
    public function notify(string $type = 'default'): ISubject
    {
        if (isset($this->observers[$type])) {
            foreach ($this->observers[$type] as $obs) {
                $obs->update($this);
            }
        }
        return $this;
    }
}