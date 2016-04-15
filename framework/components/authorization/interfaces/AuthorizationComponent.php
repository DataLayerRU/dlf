<?php

declare(strict_types = 1);

namespace dlf\components\authorization\interfaces;

use pwf\components\authorization\interfaces\Identity;

interface AuthorizationComponent
{

    public function setIdentity(Identity $user): AuthorizationComponent;

    public function getIdentity(): Identity;

    public function isAvailable(string $name): bool;
}