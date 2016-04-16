<?php

declare(strict_types = 1);

namespace pwf\components\i18n\interfaces;

interface FileTranslator extends Translator
{

    /**
     * Set path to i18n directory
     *
     * @param string $dir
     * @return FileTranslator
     */
    public function setDir(string $dir): FileTranslator;
}