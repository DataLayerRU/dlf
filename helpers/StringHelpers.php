<?php

namespace pwf\helpers\StringHelpers;

class StringHelpers
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
}