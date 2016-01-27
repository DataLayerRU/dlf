<?php

namespace pwf\exception\interfaces;

interface HttpException
{
    public function getHeaders();

    public function getContent();
}