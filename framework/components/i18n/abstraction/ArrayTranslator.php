<?php

namespace pwf\components\i18n\abstraction;

abstract class ArrayTranslator extends Translator implements \pwf\components\i18n\interfaces\ArrayTranslator
{
    /**
     * Values
     *
     * @var array
     */
    private $values = [];

    /**
     * Set map [language=>[alias => message]]
     *
     * @param array $map
     * @return ArrayTranslator
     */
    public function setMap(array $map)
    {
        $this->values = $map;
        return $this;
    }

    /**
     * Get map
     *
     * @return array
     */
    public function getMap()
    {
        return $this->values;
    }
}