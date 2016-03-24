<?php

namespace pwf\basic\interfaces;

interface View
{

    /**
     * Render view
     *
     * @param string $viewPath
     * @param array $params
     */
    public function render($viewPath, array $params = []);
}