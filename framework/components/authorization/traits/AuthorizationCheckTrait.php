<?php

namespace dlf\components\authorization\traits;

use dlf\basic\interfaces\Component;

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
    public function setAuthorizationComponent()
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