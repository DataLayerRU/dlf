<?php

namespace dlf\components\authorization;

use project\Application;
use dlf\basic\interfaces\Component;
use dlf\components\authorization\interfaces\Identity;

class Authorization implements Component
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
     */
    public function setIdentity(Identity $user)
    {
        $this->identity = $user;

        Application::$instance->getResponse()->addCookie('auth-token', $user->getAuthToken());
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
     */
    public function clearIdentity()
    {
        $this->identity = null;
        Application::$instance->getResponse()->removeCookie('auth-token');
    }

    public function isAuthorized()
    {
        return $this->identity !== null && $this->identity->getId() > 0;
    }

    public function loadConfiguration($config = [])
    {

    }

    public function init()
    {
        // TODO: autologin
    }
}