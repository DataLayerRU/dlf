<?php

declare(strict_types = 1);

namespace pwf\components\i18n\abstraction;

use pwf\components\i18n\interfaces\FileTranslator as IFileTranslator;

abstract class FileTranslator extends Translator implements IFileTranslator
{
    /**
     * Path to lang dir
     *
     * @var string
     */
    private $dir;

    /**
     * Set dir
     *
     * @param string $dir
     * @return IFileTranslator
     */
    public function setDir(string $dir): IFileTranslator
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * Get path to directory
     *
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }
}