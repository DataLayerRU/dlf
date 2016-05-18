<?php

namespace pwf\helpers;

class ArrayHelper
{

    /**
     * To array
     *
     * @param mixed $o
     * @return array
     */
    public static function toArray($o)
    {
        if (is_array($o)) {
            foreach ($o as $key => $val) {
                $o[$key] = self::toArray($val);
            }
        } elseif (is_object($o) && method_exists($o, 'toArray')) {
            return $o->toArray();
        }

        return $o;
    }

    /**
     * Groupping elements by field
     *
     * @param array $arr
     * @param string $groupField
     */
    public static function groupArray($arr, $groupField)
    {
        $result = array();
        foreach ($arr as $data) {
            $id = $data[$groupField];
            if (isset($result[$id])) {
                $result[$id][] = $data;
            } else {
                $result[$id] = array($data);
            }
        }

        return $result;
    }

    /**
     * $haystask:
     * [
     *  1=>[
     *      ID=>1,
     *      NAME=>'Name'
     *  ],
     *  2=>[
     *      ID=>2,
     *      NAME=>'Name2'
     *  ]
     * ]
     *
     * map($haystack, 'ID', 'NAME'):
     * [
     *  1=>'Name',
     *  2=>'Name2
     * ]
     *
     * map($haystack, 'NAME'):
     * [
     *  'Name', 'Name2'
     * ]
     *
     * map($haystack, null, 'ID'):
     * [
     *  1=> [
     *      ID => 1,
     *      NAME => 'Name'
     *  ],
     *  2=> [
     *      ID => 2,
     *      NAME => 'Name2'
     *  ]
     * ]
     *
     * @param array $haystack
     * @param string $valueKey
     * @param string $key
     * @return array
     */
    public static function map($haystack, $valueKey, $key = null)
    {
        $result = array();

        foreach ($haystack as $item) {
            $item = (array) $item;
            if ($key !== null && isset($item[$key])) {
                $result[$item[$key]] = $valueKey === null ? $item : $item[$valueKey];
            } else {
                $result[] = $item[$valueKey];
            }
        }

        return $result;
    }

    /**
     * Search in array
     *
     * @param mixed $needleKey
     * @param mixed $needleValue
     * @param array $haystack
     * @return integer
     */
    public static function recursiveArraySearch($needleKey, $needleValue,
                                                array $haystack)
    {
        foreach ($haystack as $key => $value) {
            $currentKey = $key;

            if (($currentKey == $needleKey && ($needleValue === null || $needleValue
                == $value)) || ( is_array($value) && recursiveArraySearch($needleKey,
                    $needleValue, $value) !== false)) {
                return $currentKey;
            }
        }
        return null;
    }

    /**
     * Set value
     *
     * @param mixed $needleKey
     * @param mixed $needleValue
     * @param array $haystack
     */
    public static function recursivelySetValue($needleKey, $needleValue,
                                               array &$haystack)
    {
        foreach ($haystack as $key => &$value) {
            if (isset($haystack[$needleKey])) {
                $haystack[$needleKey] = $needleValue;
            }

            if (is_array($value)) {
                self::recursivelySetValue($needleKey, $needleValue, $value);
            }
        }
    }

    /**
     * Get value
     *
     * @param mixed $needleKey
     * @param array $haystack
     * @return mixed
     */
    public static function recursivelyGetValue($needleKey, array &$haystack)
    {
        $result = null;
        foreach ($haystack as $key => &$value) {
            if (isset($haystack[$needleKey])) {
                $result = $haystack[$needleKey];
            } elseif (is_array($value)) {
                $result = self::recursivelyGetValue($needleKey, $value);
            }
        }
        return $result;
    }
}