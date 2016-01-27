<?php

namespace pwf\components\authorization\interfaces;

interface Identity
{
    public function getId();

    public function getAuthToken();

    public function getByAuthToken($token);

}