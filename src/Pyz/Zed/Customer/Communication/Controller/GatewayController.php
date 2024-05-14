<?php

namespace Pyz\Zed\Customer\Communication\Controller;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\EmailChangeRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationResponseTransfer;
use Pyz\Zed\Customer\Business\CustomerFacade;

/**
 * @method CustomerFacade getFacade()
 */
class GatewayController extends \Spryker\Zed\Customer\Communication\Controller\GatewayController
{
    public function createEmailChangeRequestAction(EmailChangeRequestTransfer $emailChangeRequestTransfer): CustomerResponseTransfer
    {
        $this->getFacade()
            ->createChangeEmailRequest($emailChangeRequestTransfer);

        return new CustomerResponseTransfer();
    }

    public function confirmChangeEmailRequestAction(EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer): EmailConfirmationResponseTransfer
    {
        return $this->getFacade()
            ->confirmEmailChange($emailConfirmationRequestTransfer);
    }


}
