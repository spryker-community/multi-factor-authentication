<?php

namespace Pyz\Yves\CustomerPage\Expander;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface;
use SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilderInterface;
use SprykerShop\Yves\CustomerPage\CustomerPageConfig;
use SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface;
use SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpanderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use SprykerShop\Shared\CustomerPage\CustomerPageConfig as SharedCustomerPageConfig;

class TwoFactorSecurityBuilderExpander implements SecurityBuilderExpanderInterface
{
    protected const MULTI_FACTOR_AUTHENTICATOR = 'security.secured.multi_factor.authenticator';

    /**
     * @var string
     */
    protected const ROLE_NAME_USER = 'ROLE_USER';

    /**
     * @var string
     */
    protected const ACCESS_MODE_PUBLIC = 'PUBLIC_ACCESS';

    /**
     * @uses \SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin::ROUTE_LOGIN
     *
     * @var string
     */
    protected const ROUTE_LOGIN = 'login';

    /**
     * @uses \Spryker\Yves\Router\Plugin\Application\RouterApplicationPlugin::SERVICE_ROUTER
     *
     * @var string
     */
    protected const SERVICE_ROUTER = 'routers';

    /**
     * @var \SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilderInterface
     */
    protected CustomerSecurityOptionsBuilderInterface $customerSecurityOptionsBuilder;

    /**
     * @var \SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface
     */
    protected CustomerPageToCustomerClientInterface $customerClient;

    /**
     * @var \SprykerShop\Yves\CustomerPage\CustomerPageConfig
     */
    protected CustomerPageConfig $customerPageConfig;

    /**
     * @var \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    protected EventSubscriberInterface $eventSubscriber;

    /**
     * @var \Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface
     */
    protected AuthenticatorInterface $authenticator;

    public function __construct(
        CustomerSecurityOptionsBuilderInterface $customerSecurityOptionsBuilder,
        CustomerPageToCustomerClientInterface $customerClient,
        CustomerPageConfig $customerPageConfig,
        EventSubscriberInterface $eventSubscriber,
        AuthenticatorInterface $authenticator
    ) {
        $this->customerSecurityOptionsBuilder = $customerSecurityOptionsBuilder;
        $this->customerClient = $customerClient;
        $this->customerPageConfig = $customerPageConfig;
        $this->eventSubscriber = $eventSubscriber;
        $this->authenticator = $authenticator;
    }

    public function extend(SecurityBuilderInterface $securityBuilder, ContainerInterface $container): SecurityBuilderInterface
    {
        $securityBuilder->mergeFirewall(
            SharedCustomerPageConfig::SECURITY_FIREWALL_NAME,
            [
                'multi_factor' => [
                    'authenticators' => [
                        'security.secured.multi_factor.authenticator',
                    ],
                    'trusted_parameter' => 'trusted',
                    'enable_csrf' => true,
                    'csrf_parameter' => '_csrf_token',
                    'csrf_token_id' => 'two_factor',
                ],
            ],
        );

//        $securityBuilder = $this->addAccessRules($securityBuilder);
//        $securityBuilder = $this->addAccessDeniedHandler($securityBuilder);
//        $securityBuilder = $this->addInteractiveLoginEventSubscriber($securityBuilder);
        $this->addAuthenticator($container);

        return $securityBuilder;
    }

    private function addAccessRules(SecurityBuilderInterface $securityBuilder)
    {
        return $securityBuilder->addAccessRules([
            [
                $this->customerClient->getCustomerSecuredPattern(),
                static::ROLE_NAME_USER,
            ],
            [
                $this->customerPageConfig->getAnonymousPattern(),
                static::ACCESS_MODE_PUBLIC,
            ],
        ]);
    }

    private function addAuthenticator(ContainerInterface $container)
    {
        $container->set(static::MULTI_FACTOR_AUTHENTICATOR, function () {
            return $this->authenticator;
        });
    }
}
