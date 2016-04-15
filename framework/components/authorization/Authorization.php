<?php

declare(strict_types = 1);

namespace pwf\components\authorization;

use pwf\basic\Component;
use pwf\basic\Application;
use pwf\basic\interfaces\Component as IComponent;
use pwf\components\authorization\interfaces\Identity;

class Authorization extends Component
{
    /**
     * Current user
     *
     * @var Identity
     */
    private $identity;

    /**
     * Use auto login
     *
     * @var bool
     */
    private $autoLogin;

    /**
     * Identity class name
     *
     * @var string
     */
    private $identityClass;

    /**
     * Set identity class name
     *
     * @param string $className
     * @return \pwf\components\authorization\Authorization
     */
    public function setIdentityClass(string $className): Authorization
    {
        $this->identityClass = $className;
        return $this;
    }

    /**
     * Get identity class name
     *
     * @return string
     */
    public function getIdentityClass(): string
    {
        return $this->identityClass;
    }

    /**
     * Set auto login
     *
     * @param bool $autoLogin
     * @return \pwf\components\authorization\Authorization
     */
    public function setAutoLogin(bool $autoLogin): Authorization
    {
        $this->autoLogin = $autoLogin;
        return $this;
    }

    /**
     * Is auto login
     *
     * @return bool
     */
    public function isAutoLogin(): bool
    {
        return $this->autoLogin;
    }

    /**
     * Set current user
     *
     * @param Identity $user
     * @return Authorization
     */
    public function setIdentity(Identity $user): Authorization
    {
        $this->identity = $user;

        Application::$instance->getResponse()->addCookie('accessToken',
            $user->getAuthToken());
        return $this;
    }

    /**
     * Get current user
     *
     * @return Identity
     */
    public function getIdentity(): Identity
    {
        return $this->identity;
    }

    /**
     * Remove identity / logout
     *
     * @return Authorization
     */
    public function clearIdentity(): Authorization
    {
        $this->identity = null;
        Application::$instance->getResponse()->removeCookie('accessToken');
        return $this;
    }

    /**
     * Check is authorized
     *
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->identity !== null && $this->identity->getId() > 0;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return IComponent
     */
    public function loadConfiguration(array $config = []): IComponent
    {
        parent::loadConfiguration($config);
        if (isset($config['auto'])) {
            $this->setAutoLogin((bool)$config['auto']);
        }
        if (isset($config['identityClass'])) {
            $this->setIdentityClass($config['identityClass']);
        }
        return $this;
    }

    /**
     * Component initialization
     *
     * @return IComponent
     */
    public function init(): IComponent
    {
        if ($this->isAutoLogin()) {
            $this->autoLogin();
        }
        return $this;
    }

    /**
     * Auto login
     *
     * @return Authorization
     */
    protected function autoLogin(): Authorization
    {
        $token = Application::$instance->getRequest()->get('access-token');
        if ($token === null) {
            $token = Application::$instance->getRequest()->getCookie('accessToken');
        }
        if ($token !== null) {
            $className = $this->getIdentityClass();
            $user = new $className;
            $this->setIdentity($user->getByAuthToken($token));
        }
        return $this;
    }
}