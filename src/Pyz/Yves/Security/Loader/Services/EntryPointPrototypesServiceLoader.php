<?php

namespace Pyz\Yves\Security\Loader\Services;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\Security\Loader\Services\EntryPointPrototypesServiceLoader as SprykerEntryPointPrototypesServiceLoader;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

class EntryPointPrototypesServiceLoader extends SprykerEntryPointPrototypesServiceLoader
{
    private const SERVICE_SECURITY_ENTRY_POINT_MULTI_FACTOR_PROTO = 'security.entry_point.multi_factor._proto';

    public function add(ContainerInterface $container): ContainerInterface
    {
        $container = parent::add($container);

        $container = $this->addEntryPointMultiFactorPrototype($container);

        return $container;
    }

    private function addEntryPointMultiFactorPrototype(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_SECURITY_ENTRY_POINT_MULTI_FACTOR_PROTO, $container->protect(function (string $firewallName, array $options) use ($container): callable {
            return function () use ($container, $options, $firewallName): ?AuthenticatorInterface {
                $options[static::OPTION_LOGIN_PATH] = '/mfa';
                $options[static::OPTION_USE_FORWARD] = true;


                return $container->get( 'security.secured.multi_factor.authenticator');

            };
        }));

        return $container;
    }

}
