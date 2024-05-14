<?php

namespace Pyz\Yves\MultiFactorAuthentication;

use Pyz\Yves\MultiFactorAuthentication\Form\FormFactory;
use Spryker\Client\Session\SessionClientInterface;
use SprykerShop\Yves\CustomerPage\CustomerPageFactory as SprykerCustomerPageFactory;

class MultiFactorAuthenticationFactory extends SprykerCustomerPageFactory
{
    /**
     * @return \Spryker\Client\Session\SessionClientInterface
     */
    public function getSessionClient(): SessionClientInterface
    {
        return $this->getProvidedDependency(MultiFactorAuthenticationDependencyProvider::CLIENT_SESSION);
    }

    /**
     * @return \Pyz\Yves\MultiFactorAuthentication\Form\FormFactory
     */
    public function createMultiFactorAuthenticationFormFactory(): FormFactory
    {
        return new FormFactory();
    }
}
