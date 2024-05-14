<?php

namespace Pyz\Client\Customer;

use Pyz\Client\Customer\Zed\CustomerStubInterface;
use Spryker\Client\Customer\CustomerDependencyProvider;
use Pyz\Client\Customer\Zed\CustomerStub;

class CustomerFactory extends \Spryker\Client\Customer\CustomerFactory
{

    /**
     * @return \Pyz\Client\Customer\Zed\CustomerStubInterface
     */
    public function createZedCustomerStub(): CustomerStubInterface
    {
        return new CustomerStub($this->getProvidedDependency(CustomerDependencyProvider::SERVICE_ZED));
    }


}
