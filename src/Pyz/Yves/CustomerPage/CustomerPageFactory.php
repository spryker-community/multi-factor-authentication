<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomerPage;

use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Yves\CustomerPage\Authenticator\MultiFactorAuthenticator;
use Pyz\Yves\CustomerPage\Expander\TwoFactorSecurityBuilderExpander;
use Spryker\Client\Session\SessionClientInterface;
use SprykerShop\Shared\CustomerPage\CustomerPageConfig;
use SprykerShop\Yves\CustomerPage\CustomerPageFactory as SprykerCustomerPageFactory;
use SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpander;
use SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpanderInterface;
use SprykerShop\Yves\CustomerPage\Plugin\Security\CustomerPageSecurityPlugin;
use SprykerShop\Yves\CustomerPage\Security\Customer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CustomerPageFactory extends SprykerCustomerPageFactory
{
    /**
     * @return \Spryker\Client\Session\SessionClientInterface
     */
    public function getSessionClient(): SessionClientInterface
    {
        return $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_SESSION);
    }

    public function createSecurityUser(CustomerTransfer $customerTransfer): Customer
    {
        $user = parent::createSecurityUser($customerTransfer);

        return new Customer(
            $customerTransfer,
            $customerTransfer->getEmail(),
            $customerTransfer->getPassword(),
            [CustomerPageSecurityPlugin::ROLE_NAME_USER . '-ALMOST'],
        );
    }

    public function createUsernamePasswordToken(CustomerTransfer $customerTransfer): TokenInterface
    {
        return new UsernamePasswordToken(
            $this->createSecurityUser($customerTransfer),
            CustomerPageConfig::SECURITY_FIREWALL_NAME,
            [CustomerPageSecurityPlugin::ROLE_NAME_USER . '-ALMOST'],
        );
    }

    public function createTwoFactorSecurityBuilderExpander(): SecurityBuilderExpanderInterface
    {
        return new TwoFactorSecurityBuilderExpander(
            $this->createCustomerSecurityOptionsBuilder(),
            $this->getCustomerClient(),
            $this->getConfig(),
            $this->createInteractiveLoginEventSubscriber(),
            $this->createMultiFactorAuthenticator(),
        );
    }

    private function createMultiFactorAuthenticator(): MultiFactorAuthenticator
    {
        return new MultiFactorAuthenticator();
    }

}
