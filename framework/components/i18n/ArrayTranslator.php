<?php

namespace pwf\components\i18n;

class ArrayTranslator extends \pwf\components\i18n\abstraction\ArrayTranslator
{

    use traits\ParamReplace;

    /**
     * Translate string
     *
     * @param string $alias
     * @param array $params
     * @return string
     */
    public function translate(string $alias, array $params = []): string
    {
        $result = '';

        $values = $this->getMap();
        if (isset($values[$this->getLanguage()][$alias])) {
            $result = $this->prepareValue($values[$this->getLanguage()][$alias],
                $params);
        }
        if (isset($values[$alias])) {
            $result = $this->prepareValue($values[$alias], $params);
        }

        return $result;
    }
}