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
        ContainerInterface $container
    ): SecurityBuilderInterface {
        $securityBuilder->addFirewall(
            '2fa',
            [
                'pattern' => '^/',
                'context' => 'agent',
                'form' => [
                    'login_path' => '2fa',
                    'check_path' => '2fa_check',
                    'authenticators' => [],
                ],
            ],
        );
        return $securityBuilder;
    }
}
