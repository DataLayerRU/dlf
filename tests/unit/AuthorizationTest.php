<?php

class App
{

    use \pwf\components\authorization\traits\AuthorizationCheckTrait;
}

class Component extends \pwf\basic\Component
{

    public function init()
    {
        
    }
}

class Identity implements \pwf\components\authorization\interfaces\Identity
{

    public function getAuthToken()
    {
        return 'jsdhfjk4776';
    }

    public function getByAuthToken($token)
    {
        return $this;
    }

    public function getId()
    {
        return 1;
    }
}

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{

    public function testIt()
    {
        $identity = \Codeception\Util\Stub::make('Identity');

        $authStub = \Codeception\Util\Stub::construct('\pwf\components\authorization\Authorization');
        $authStub->loadConfiguration([
            'auto' => true,
            'identityClass' => $identity
        ]);

        $this->assertTrue($authStub->isAutoLogin());

        \pwf\basic\Application::$instance = new \pwf\basic\Application();

        $this->assertEquals($identity,
            $authStub->setIdentity($identity)->getIdentity());
        $this->assertEmpty($authStub->clearIdentity()->getIdentity());
        $this->assertTrue($authStub->setIdentity($identity)->isAuthorized());

        $_COOKIE['accessToken'] = 'jsdhfjk4776';
        $this->assertInstanceOf('\pwf\components\authorization\interfaces\Identity',
            $authStub->init()->getIdentity());
    }

    public function testTraits()
    {
        $component = new Component();

        $appStub = \Codeception\Util\Stub::make('App');

        $this->assertEquals($component,
            $appStub->setAuthorizationComponent($component)->getAuthorizationComponent());
    }
}