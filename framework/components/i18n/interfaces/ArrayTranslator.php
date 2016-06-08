<?php

namespace pwf\components\i18n\interfaces;

interface ArrayTranslator extends Translator
{

    /**
     * Set map [language=>[alias => message]]
     *
     * @param array $map
     * @return ArrayTranslator
     */
    public function setMap(array $map);
}