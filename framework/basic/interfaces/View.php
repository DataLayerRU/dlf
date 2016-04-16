<?php

declare(strict_types = 1);

namespace pwf\basic\interfaces;

interface View
{

    /**
     * Render view
     *
     * @param string $viewPath
     * @param array $params
     * @return string
     */
    public function render(string $viewPath, array $params = []): string;
}