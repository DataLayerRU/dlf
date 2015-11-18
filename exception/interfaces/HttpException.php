<?php

namespace dlf\exception\interfaces;

interface HttpException
{
    public function getHeaders();

    public function getContent();
}