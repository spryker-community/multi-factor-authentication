<?php

namespace Pyz\Client\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\EmailChangeRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationResponseTransfer;
use SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface;

interface CustomerClientInterface extends \Spryker\Client\Customer\CustomerClientInterface, CustomerPageToCustomerClientInterface
{

    public function createEmailChangeRequest(EmailChangeRequestTransfer $emailChangeRequestTransfer): CustomerResponseTransfer;

    public function confirmChangeEmailRequest(\Generated\Shared\Transfer\EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer): EmailConfirmationResponseTransfer;
}
