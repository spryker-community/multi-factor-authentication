<?php

namespace Pyz\Yves\CustomerPage\Plugin\Security;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface;
use Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;

class TwoFactorAuthenticationSecurityPlugin extends AbstractPlugin implements SecurityPluginInterface
{

    public function extend(
        SecurityBuilderInterface $securityBuilder,
        ContainerInterface       $container
    ): SecurityBuilderInterface
    {
        return $this->getFactory()->createTwoFactorSecurityBuilderExpander()->extend($securityBuilder, $container);
    }

}
