<?php

namespace Pyz\Yves\Security;

use Pyz\Yves\Security\AuthenticationListener\AuthenticationListener;
use Spryker\Yves\Security\AuthenticationListener\AuthenticationListenerInterface;
use Pyz\Yves\Security\Loader\Services\AuthenticationListenerPrototypesServiceLoader;
use Spryker\Yves\Security\Loader\Services\ServiceLoaderInterface;
use Spryker\Yves\Security\SecurityFactory as SprykerSecurityFactory;

class SecurityFactory extends SprykerSecurityFactory
{
    public function createAuthenticationListener(): AuthenticationListenerInterface
    {
        return new AuthenticationListener(
            $this->getSecurityAuthenticationListenerFactoryTypeExpanderPlugins(),
        );
    }

    public function createAuthenticationListenerPrototypesServiceLoader(): ServiceLoaderInterface
    {
        return new AuthenticationListenerPrototypesServiceLoader(
            $this->createSecurityConfigurator(),
            $this->getSecurityRouter(),
            $this->createAuthenticatorManager(),
        );
    }
}
