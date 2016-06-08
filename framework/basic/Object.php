<?php

namespace pwf\basic;

class Object
{

    /**
     * Set property
     *
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        $methodName = 'set'.ucfirst($name);
        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        } else {
            throw new \Exception('No field named \''.$name.'\'');
        }
    }

    /**
     * Get property value
     *
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        $methodName = 'get'.ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        throw new \Exception('No field named \''.$name.'\'');
    }
}