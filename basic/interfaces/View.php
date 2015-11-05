<?php

namespace dlf\basic\interfaces;

interface View
{

    public function render($viewPath, $params = []);
}