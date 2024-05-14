<?php

namespace Pyz\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\EmailChangeRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationRequestTransfer;
use Pyz\Yves\CustomerPage\CustomerPageFactory;
use SprykerShop\Yves\CustomerPage\Controller\AbstractCustomerController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method CustomerPageFactory getFactory()
 */
class ChangeEmailController extends AbstractCustomerController
{
    // todo adjust RouteProviderPlugin
    public function changeEmailFormAction(Request $request)
    {
        if ($this->isLoggedInCustomer() !== true) {
            dd('You have to login');
        }
        if ($request->isMethod('POST')) {
            // TODO send email
            $emailChangeRequestTransfer = new EmailChangeRequestTransfer();
            $emailChangeRequestTransfer->setNewEmail($request->get('new_email'));
            $customer = $this->getLoggedInCustomerTransfer();

            $emailChangeRequestTransfer->setOldEmail($customer->getEmail());
            $emailChangeRequestTransfer->setCustomer($customer);
            $this->getFactory()->getCustomerClient()->createEmailChangeRequest($emailChangeRequestTransfer);

            dd('We received your request to change your email - please login into both email accounts (old and new) and click the links to confirm your email change request');
        }
        $response = [];
        return $this->view($response, [], '@CustomerPage/views/change-email-form.twig');
    }

    public function changeEmailConfirmAction(Request $request)
    {
        $emailConfirmationRequestTransfer = new EmailConfirmationRequestTransfer();
        $emailConfirmationRequestTransfer->setConfirmationHashOld($request->query->get('oldHash'));
        $emailConfirmationRequestTransfer->setConfirmationHashNew($request->query->get('newHash'));
        $emailConfirmationRequestTransfer->setIdCustomer($request->query->get('idCustomer'));
        // TBD should contain checking the customer and the hash and confirm email
        $changeEmailState = $this->getFactory()->getCustomerClient()->confirmChangeEmailRequest($emailConfirmationRequestTransfer);

        $response = [
            'oldMailConfirmed' => $changeEmailState->getOldMailConfirmed(),
            'newMailConfirmed' => $changeEmailState->getNewMailConfirmed(),
            'fullyProcessed' => $changeEmailState->getFullyProcessed(),
        ];
        return $this->view($response, [], '@CustomerPage/views/change-email-confirm.twig');
    }

}
