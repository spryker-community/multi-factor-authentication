<?php

namespace Pyz\Client\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\EmailChangeRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationResponseTransfer;

/**
 * @method CustomerFactory getFactory()
 */
class CustomerClient extends \Spryker\Client\Customer\CustomerClient implements CustomerClientInterface
{

    public function createEmailChangeRequest(EmailChangeRequestTransfer $emailChangeRequestTransfer): CustomerResponseTransfer
    {
        return $this->getFactory()
            ->createZedCustomerStub()
            ->createEmailChangeRequest($emailChangeRequestTransfer);
    }

    public function confirmChangeEmailRequest(\Generated\Shared\Transfer\EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer): EmailConfirmationResponseTransfer
    {
        return $this->getFactory()
            ->createZedCustomerStub()
            ->confirmChangeEmailRequest($emailConfirmationRequestTransfer);
    }
}
