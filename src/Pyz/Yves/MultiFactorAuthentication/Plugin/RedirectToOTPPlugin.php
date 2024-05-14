<?php

namespace Pyz\Yves\MultiFactorAuthentication\Plugin;

use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Yves\MultiFactorAuthentication\Plugin\Router\MultiFactorAuthenticationRouteProviderPlugin;
use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\Router\Router\ChainRouter;
use SprykerShop\Yves\CustomerPageExtension\Dependency\Plugin\CustomerRedirectStrategyPluginInterface;

/**
 * Simple Plugin to redirect to OTP-Page - always applicable
 *
 * @method \SprykerShop\Yves\MultiFactorAuthentication\MultiFactorAuthenticationFactory getFactory()
 */
class RedirectToOTPPlugin extends AbstractPlugin implements CustomerRedirectStrategyPluginInterface
{
    /**
     * @uses \Spryker\Shared\Application\Application::SERVICE_REQUEST
     *
     * @var string
     */
    protected const REQUEST = 'request';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function isApplicable(CustomerTransfer $customerTransfer): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function getRedirectUrl(CustomerTransfer $customerTransfer): string
    {
        return $this->getRouter()->generate(MultiFactorAuthenticationRouteProviderPlugin::ROUTE_NAME_ENTER_SECOND_FACTOR);
    }

    /**
     * @return \Spryker\Yves\Router\Router\ChainRouter
     */
    protected function getRouter(): ChainRouter
    {
        return $this->getFactory()->getRouter();
    }
}
