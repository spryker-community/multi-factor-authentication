<?php

namespace Pyz\Client\Customer\Zed;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerStub extends \Spryker\Client\Customer\Zed\CustomerStub implements CustomerStubInterface
{

    public function createEmailChangeRequest(\Generated\Shared\Transfer\EmailChangeRequestTransfer $emailChangeRequestTransfer): CustomerResponseTransfer
    {
        return $this->zedStub->call('/customer/gateway/create-email-change-request', $emailChangeRequestTransfer);
    }

    public function confirmChangeEmailRequest(\Generated\Shared\Transfer\EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer)
    {
        return $this->zedStub->call('/customer/gateway/confirm-change-email-request', $emailConfirmationRequestTransfer);
    }
}
