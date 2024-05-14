<?php

namespace Pyz\Yves\Security\Loader\Services;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\Security\Loader\Services\AuthenticationListenerPrototypesServiceLoader as SprykerAuthenticationListenerPrototypesServiceLoader;
use Symfony\Component\Security\Http\EventListener\CheckCredentialsListener;
use Symfony\Component\Security\Http\Firewall\AuthenticatorManagerListener;
use Symfony\Component\Security\Http\Firewall\FirewallListenerInterface;

class AuthenticationListenerPrototypesServiceLoader extends SprykerAuthenticationListenerPrototypesServiceLoader
{
    const SERVICE_SECURITY_AUTHENTICATION_LISTENER_MULTI_FACTOR_PROTO = 'security.authentication_listener.multi_factor._proto';

    public function add(ContainerInterface $container): ContainerInterface
    {
        $container = parent::add($container);

        $container = $this->addAuthenticationListenerMultiFactorPrototype($container);

        return $container;
    }

    private function addAuthenticationListenerMultiFactorPrototype(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_SECURITY_AUTHENTICATION_LISTENER_MULTI_FACTOR_PROTO, $container->protect(function (string $firewallName, array $options) use ($container): callable {
            return function () use ($container, $firewallName, $options): FirewallListenerInterface {
                $this->securityRouter->addSecurityRoute('mfa');

//                $this->getDispatcher($container)->addSubscriber(
//                    new CheckCredentialsListener($container->get(static::SERVICE_SECURITY_HASHER_FACTORY)),
//                );

                /** @var \Symfony\Component\Security\Http\Firewall\FirewallListenerInterface $class */
                    $class = $options[static::OPTION_LISTENER_CLASS] ?? AuthenticatorManagerListener::class;

//                if ($container->has(static::SECURITY_REMEMBER_ME_AUTHENTICATOR)) {
//                    $options[static::KEY_AUTHENTICATORS] = array_merge($options[static::KEY_AUTHENTICATORS], [static::SECURITY_REMEMBER_ME_AUTHENTICATOR]);
//                }

                return new $class(
                    $this->authenticatorManager->create($container, $firewallName, $options),
                );
            };
        }));

        return $container;
    }
}
