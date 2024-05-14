<?php

namespace Pyz\Yves\Security;

use Pyz\Yves\Security\AuthenticationListener\AuthenticationListener;
use Pyz\Yves\Security\Loader\Services\AuthenticationListenerPrototypesServiceLoader;
use Pyz\Yves\Security\Loader\Services\EntryPointPrototypesServiceLoader;
use Spryker\Yves\Security\AuthenticationListener\AuthenticationListenerInterface;
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

    /**
     * @return \Spryker\Yves\Security\Loader\Services\ServiceLoaderInterface
     */
    public function createEntryPointPrototypesServiceLoader(): ServiceLoaderInterface
    {
        return new EntryPointPrototypesServiceLoader();
    }
}
