<?php

declare(strict_types = 1);

namespace pwf\helpers;

class StringHelpers
{

    /**
     * Hast string
     *
     * @param string $string
     * @param int $iteration
     * @return string
     */
    public static function hashString(string $string, int $iteration = 5): string
    {
        $result = $string;

        for ($i = 0; $i < $iteration; $i++) {
            $result = md5($result);
        }

        return $result;
    }
}