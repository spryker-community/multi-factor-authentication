<?php

/**
 * Basic Idea for second factor for any action:
 * - when action should be executed, customer is redirected to 2fa-page (action is transferred as well but not executed yet)
 * - email is sent to customer containing an OTP for the given action (TODO where do I get the email from in case of login? - in other cases we could just take the mail from CustomerClient)
 * - customer is prompted with the OTP-form for the given action
 * - after successful confirmation of OTP the action is executed (TODO how can this be achieved? redirect to somewhere? implement otp in place where the action is usually executed?)
 */

/**
 * TODO how could this be introduced into email change process or password change process?
 * EMAIL-CHANGE:
 *      - when triggering an email change, send otp mail and show otp form (in place implementation), after submit, execute email change
 *
 * EMAIL-CHANGE-SECURE WITHOUT OTP
 * - when triggering email change
 *          -> generate entry in pyz_change_email_request (id, fk_customer, old_email, old_email_token, old_email_validated, new_email, new_email_token, new_email_validated, created_at)
 *          -> send emails to both accounts with token-links incl. id
 *          -> when accessing token link, load data via id and check whether token is there - if that's the case -> set validated-field to true and show current state (if both validated already change email)
 *
 */

namespace Pyz\Yves\MultiFactorAuthentication\Controller;

use SprykerShop\Yves\CustomerPage\Controller\AbstractCustomerController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\MultiFactorAuthentication\MultiFactorAuthenticationFactory getFactory()
 */
class EnterSecondFactorController extends AbstractCustomerController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $response = $this->executeIndexAction($request);

        if (!is_array($response)) {
            return $response;
        }

        return $this->view($response, [], '@MultiFactorAuthentication/views/confirm-second-factor.twig');
    }

    private function executeIndexAction(Request $request)
    {
        $confirmSecondFactorForm = $this
            ->getFactory()
            ->createMultiFactorAuthenticationFormFactory()
            ->getConfirmSecondFactorForm()
            ->handleRequest($request);

        if (!$this->getFactory()->getTokenStorage()->getToken()->hasAttribute('otp')) {
            $this->getFactory()->getTokenStorage()->getToken()->setAttribute('otp', sha1('123456'));
        }

        if (!$confirmSecondFactorForm->isSubmitted()) {
            return [
                'confirmSecondFactorForm' => $confirmSecondFactorForm->createView(),
            ];
        }
    }
}
