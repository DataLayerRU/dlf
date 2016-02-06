<?php

namespace dlf\components\authorization\interfaces;

interface AuthorizationComponent
{

    public function setIdentity(Identity $user);

    public function getIdentity();

    public function isAvailable($name);
}