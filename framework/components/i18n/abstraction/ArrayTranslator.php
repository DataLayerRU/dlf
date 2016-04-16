<?php

declare(strict_types = 1);

namespace pwf\components\i18n\abstraction;

use pwf\components\i18n\interfaces\ArrayTranslator as IArrayTranslator;

abstract class ArrayTranslator extends Translator implements IArrayTranslator
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
     * @return IArrayTranslator
     */
    public function setMap(array $map): IArrayTranslator
    {
        $this->values = $map;
        return $this;
    }

    /**
     * Get map
     *
     * @return array
     */
    public function getMap(): array
    {
        return $this->values;
    }
}