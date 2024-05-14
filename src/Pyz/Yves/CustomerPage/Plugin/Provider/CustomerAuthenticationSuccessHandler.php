<?php

namespace Pyz\Yves\CustomerPage\Plugin\Provider;

use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerAuthenticationSuccessHandler as SprykerCustomerAuthenticationSuccessHandler;

class CustomerAuthenticationSuccessHandler extends SprykerCustomerAuthenticationSuccessHandler
{
    protected function determineTargetUrl($request)
    {
        return '/enter-second-factor';
    }
}
