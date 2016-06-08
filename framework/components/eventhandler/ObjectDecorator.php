<?php

namespace pwf\components\eventhandler;

class ObjectDecorator extends Object implements interfaces\EventHandler
{

    use traits\EventTrait;
    /**
     * Event names
     */
    const EVENT_BEFORE_METHOD = 'before_method';
    //
    const EVENT_AFTER_METHOD  = 'after_method';

    /**
     * Decorated object
     *
     * @var object
     */
    private $o;

    /**
     * Set decorated object
     *
     * @param object $o
     * @return \pwf\basic\ObjectDecorator
     */
    public function setObject($o)
    {
        $this->o = $o;
        return $this;
    }

    /**
     * Get decorated object
     *
     * @return object
     */
    public function getObject()
    {
        return $this->o;
    }

    /**
     * Invoke method in decorated object
     *
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     */
    public function invoke($methodName, array $arguments = [])
    {
        $this->trigger(self::EVENT_BEFORE_METHOD);
        $result = call_user_method_array($methodName, $this->o, $arguments);
        $this->trigger(self::EVENT_AFTER_METHOD);
        return $result;
    }

    /**
     * Invoke static method in decorated object
     *
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     */
    public function invokeStatic($methodName, array $arguments = [])
    {
        $this->trigger(self::EVENT_BEFORE_METHOD);
        $result = forward_static_call([$methodName, get_class($this->o)],
            $arguments);
        $this->trigger(self::EVENT_AFTER_METHOD);
        return $result;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->invoke($name, $arguments);
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __callStatic($name, $arguments)
    {
        return $this->invokeStatic($name, $arguments);
    }
}