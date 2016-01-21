<?php

namespace pwf\basic\interfaces;

interface View
{

    public function render($viewPath, $params = []);
}