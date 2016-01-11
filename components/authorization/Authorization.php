<?php

namespace dlf\components\authorization;

use project\Application;
use dlf\basic\interfaces\Component;
use dlf\components\authorization\interfaces\Identity;
use dlf\components\authorization\interfaces\AuthorizationComponent;

class Authorization implements Component, AuthorizationComponent
{
    /**
     * Current user
     *
     * @var Identity
     */
    private $identity;

    /**
     * Set current user
     *
     * @param Identity $user
     * @return Authorization
     */
    public function setIdentity(Identity $user)
    {
        $this->identity = $user;

        Application::$instance->getResponse()->addCookie('auth-token', $user->getAuthToken());
        return $this;
    }

    /**
     * Get current user
     *
     * @return Identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Remove identity / logout
     *
     * @return Authorization
     */
    public function clearIdentity()
    {
        $this->identity = null;
        Application::$instance->getResponse()->removeCookie('auth-token');
        return $this;
    }

    public function isAuthorized()
    {
        return $this->identity !== null && $this->identity->getId() > 0;
    }

    public function loadConfiguration($config = [])
    {

    }

    public function isAvailable($name)
    {
        return true;
    }

    public function init()
    {
        // TODO: autologin
    }
}