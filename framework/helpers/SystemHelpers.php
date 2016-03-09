<?php

namespace pwf\helpers;

class SystemHelpers
{

    /**
     * Call function with dependency injection
     *
     * @param mixed $function
     * @param \Closure $callback
     * @return mixed
     */
    public static function call($function, \Closure $callback = null)
    {
        $result = null;
        if (is_array($function)) {
            $result = self::methodDI($function, $callback);
        } elseif (is_callable($function, true)) {
            $result = self::functionDI($function, $callback);
        }
        return $result;
    }

    /**
     * Call closure with dependency injection
     *
     * @param \Closure $function
     * @param \Closure $callback
     * @return mixed
     */
    public static function functionDI(\Closure $function,
                                      \Closure $callback = null)
    {
        $reflection     = new \ReflectionFunction($function);
        $functionParams = $reflection->getParameters();
        $inputParams    = [];
        if ($callback !== null) {
            foreach ($functionParams as $functionParam) {
                $param = $callback($functionParam->name);
                if (!empty($param)) {
                    $inputParams[] = $param;
                }
            }
        }
        return call_user_func_array($function, $inputParams);
    }

    /**
     * Call method with dependency injection
     *
     * @param array $objectInfo
     * @param \Closure $callback
     * @return mixed
     */
    public static function methodDI(array $objectInfo, \Closure $callback = null)
    {
        $reflection     = new \ReflectionObject($objectInfo[0]);
        $methods        = $reflection->getMethods();
        $inputParams    = [];
        $functionParams = [];
        foreach ($methods as $method) {
            if ($objectInfo[1] == $method->name) {
                $functionParams = $method->getParameters();
                break;
            }
        }
        foreach ($functionParams as $functionParam) {
            $param = $callback($functionParam->name);
            if (!empty($param)) {
                $inputParams[] = $param;
            }
        }
        return call_user_func_array($objectInfo, $inputParams);
    }

    /**
     * Create object byclass name and arguments for constructor
     *
     * @param array $className
     * @param string $className
     * @return object
     */
    public static function createObject($className, array $className = [])
    {
        $ref = new \ReflectionClass($className);
        return $ref->newInstanceArgs($className);
    }
}