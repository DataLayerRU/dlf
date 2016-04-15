<?php

namespace pwf\exception\interfaces;

interface HttpException
{
    public function getHeaders(): array;

    public function getContent(): string;
}