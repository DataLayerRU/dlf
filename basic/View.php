<?php

namespace dlf\basic;

class View implements \dlf\basic\interfaces\View
{

    /**
     * Render view file
     *
     * @param string $viewPath
     * @param array $params
     * @return mixed
     */
    public function render($viewPath, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require('../'.$viewPath);

        return ob_get_clean();
    }
}