<?php

declare(strict_types = 1);

namespace pwf\components\authorization\traits;

use pwf\basic\interfaces\Component;

trait AuthorizationCheckTrait
{
    /**
     * Authorization component
     *
     * @var Component
     */
    private $authComponent;

    /**
     * Set component
     *
     * @param Component $authComponent
     * @return $this
     */
    public function setAuthorizationComponent(Component $authComponent)
    {
        $this->authComponent = $authComponent;
        return $this;
    }

    /**
     * Get component
     *
     * @return Component
     */
    public function getAuthorizationComponent()
    {
        return $this->authComponent;
    }

    /**
     * Is handler available
     *
     * @return boolean
     */
    protected function checkHandlerAccess()
    {
        return true;
    }
}