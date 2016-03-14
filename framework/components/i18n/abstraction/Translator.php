<?php

namespace pwf\components\i18n\abstraction;

abstract class Translator implements \pwf\components\i18n\interfaces\Translator
{
    /**
     * Current system language
     *
     * @var string
     */
    private $currentLanguage;

    /**
     * Set current language
     *
     * @param string $lang
     * @return \pwf\components\i18n\abstraction\Translator
     */
    public function setLanguage($lang)
    {
        $this->currentLanguage = $lang;
        return $this;
    }

    /**
     * Get current language
     *
     * @return \pwf\components\i18n\abstraction\Translator
     */
    public function getLanguage()
    {
        return $this;
    }
}