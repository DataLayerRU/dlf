<?php

namespace pwf;

class Helpers
{

    /**
     * Hast string
     *
     * @param string $string
     * @param int $iteration
     * @return string
     */
    public static function hashString($string, $iteration = 5)
    {
        $result = $string;

        for ($i = 0; $i < $iteration; $i++) {
            $result = md5($result);
        }

        return $result;
    }

    /**
     * Call function with dependency injection
     *
     * @param mixed $function
     * @param \Closure $callback
     * @return mixed
     */
    public static function call($function, \Closure $callback = null)
    {
        if (is_array($function)) {
            return self::methodDI($function, $callback);
        } elseif (is_callable($function, true)) {
            return self::functionDI($function, $callback);
        }
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
                if (!empty($param = $callback($functionParam->name))) {
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
            if (!empty($param = $callback($functionParam->name))) {
                $inputParams[] = $param;
            }
        }
        return call_user_func_array($objectInfo, $inputParams);
    }
}