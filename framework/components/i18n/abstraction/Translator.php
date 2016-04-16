<?php

declare(strict_types = 1);

namespace pwf\components\i18n\abstraction;

use pwf\components\i18n\interfaces\Translator as ITranslator;

abstract class Translator implements ITranslator
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
     * @return ITranslator
     */
    public function setLanguage(string $lang): ITranslator
    {
        $this->currentLanguage = $lang;
        return $this;
    }

    /**
     * Get current language
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->currentLanguage;
    }
}