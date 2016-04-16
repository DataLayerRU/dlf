<?php

namespace pwf\basic;

class View extends Object implements \pwf\basic\interfaces\View
{

    /**
     * Render view file
     *
     * @param string $viewPath
     * @param array $params
     * @return string
     */
    public function render($viewPath, array $params = [])
    {
        ob_start();
        ob_implicit_flush(0);
        extract($params, EXTR_OVERWRITE);
        require(file_exists($viewPath) ? $viewPath : '../'.$viewPath);

        return ob_get_clean();
    }
}