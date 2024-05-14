<?php

namespace Pyz\Client\Customer\Zed;

interface CustomerStubInterface extends \Spryker\Client\Customer\Zed\CustomerStubInterface
{

    public function createEmailChangeRequest(\Generated\Shared\Transfer\EmailChangeRequestTransfer $emailChangeRequestTransfer);

    public function confirmChangeEmailRequest(\Generated\Shared\Transfer\EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer);
}
