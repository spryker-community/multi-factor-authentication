<?php

namespace Pyz\Yves\MultiFactorAuthentication;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\CustomerPage\CustomerPageDependencyProvider as SprykerShopCustomerPageDependencyProvider;

class MultiFactorAuthenticationDependencyProvider extends SprykerShopCustomerPageDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_SESSION = 'CLIENT_SESSION';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addSessionClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSessionClient(Container $container): Container
    {
        $container->set(static::CLIENT_SESSION, function (Container $container) {
            return $container->getLocator()->session()->client();
        });

        return $container;
    }
}
