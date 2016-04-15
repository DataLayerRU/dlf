<?php

declare(strict_types = 1);

namespace pwf\components\i18n\traits;

trait ParamReplace
{

    /**
     * Prepare string
     *
     * @param string $str
     * @param array $params
     * @return string
     */
    protected function prepareValue(string $str, array $params = []): string
    {
        $result = $str;
        foreach ($params as $key => $value) {
            $result = str_replace('{' . $key . '}', $value, $result);
        }
        return $result;
    }
}