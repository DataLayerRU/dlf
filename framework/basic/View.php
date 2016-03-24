<?php

namespace pwf\basic;

class View extends Object implements \pwf\basic\interfaces\View
{

    /**
     * Render view file
     *
     * @param string $viewPath
     * @param array $params
     * @return mixed
     */
    public function render($viewPath, array $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require(file_exists($viewPath) ? $viewPath : '../'.$viewPath);

        return ob_get_clean();
    }
}