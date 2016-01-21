<?php

namespace pwf\basic\interfaces;

interface Component
{

    public function loadConfiguration($config = []);

    public function init();
}