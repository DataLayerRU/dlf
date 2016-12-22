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
     * Default language
     *
     * @var string
     */
    private $defaultLanguage;

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
        return $this->currentLanguage;
    }

    /**
     * Set default language
     *
     * @param string $lang
     * @return \pwf\components\i18n\abstraction\Translator
     */
    public function setDefaultLanguage($lang)
    {
        $this->defaultLanguage = $lang;
        return $this;
    }

    /**
     * Get default language
     *
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }
}