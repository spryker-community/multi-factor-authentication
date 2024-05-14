<?php

namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\EmailConfirmationRequestTransfer;
use Generated\Shared\Transfer\EmailConfirmationResponseTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\PyzChangeEmailRequestEntityTransfer;
use Orm\Zed\Customer\Persistence\PyzChangeEmailRequestQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Customer\Persistence\CustomerQueryContainer;

class CustomerFacade extends \Spryker\Zed\Customer\Business\CustomerFacade
{
    public function createChangeEmailRequest(\Generated\Shared\Transfer\EmailChangeRequestTransfer $emailChangeRequestTransfer)
    {
        $entity = new PyzChangeEmailRequestEntityTransfer();
        $entity->setFkCustomer($emailChangeRequestTransfer->getCustomer()->getIdCustomer());
        $entity->setOldEmail($emailChangeRequestTransfer->getOldEmail());
        $entity->setNewEmail($emailChangeRequestTransfer->getNewEmail());
        // todo generate random entries
        $entity->setOldEmailToken('abc123');
        $entity->setNewEmailToken('abc456');
        // todo does not work
        $this->getEntityManager()->save($entity);

        // TODO send mails
/*        $emailTransfer = new MailTransfer();
        $emailTransfer->setCustomer($emailTransfer->getCustomer()->setConfirmationLink('http://yves.de.spryker.local/change-email-confirm?idCustomer=1&newHash=abc456'));
        $emailTransfer->setRecipients([$emailChangeRequestTransfer->getOldEmail()]);
  */

    }

    public function confirmEmailChange(EmailConfirmationRequestTransfer $emailConfirmationRequestTransfer): EmailConfirmationResponseTransfer
    {
        $query = new PyzChangeEmailRequestQuery();
        $query->filterByFkCustomer($emailConfirmationRequestTransfer->getIdCustomer());
        if ($emailConfirmationRequestTransfer->getConfirmationHashNew()) {
            $query->filterByNewEmailToken($emailConfirmationRequestTransfer->getConfirmationHashNew());
        }
        if ($emailConfirmationRequestTransfer->getConfirmationHashOld()) {
            $query->filterByOldEmailToken($emailConfirmationRequestTransfer->getConfirmationHashOld());
        }

        $entity = $query->findOne();
        if (!$entity->isNew()) {
            if ($emailConfirmationRequestTransfer->getConfirmationHashNew()) {
                $entity->setNewEmailConfirmed(true);
            }
            if ($emailConfirmationRequestTransfer->getConfirmationHashOld()) {
                $entity->setOldEmailConfirmed(true);
            }
        }
        $entity->save();

        $response = new EmailConfirmationResponseTransfer();
        $response->setNewMailConfirmed($entity->getNewEmailConfirmed());
        $response->setOldMailConfirmed($entity->getOldEmailConfirmed());
        $response->setFullyProcessed($entity->getNewEmailConfirmed() && $entity->getOldEmailConfirmed());

        if ($response->getFullyProcessed()) {
            // todo change the email
            $customerQuery = SpyCustomerQuery::create();
            $customer = $customerQuery->findOneByIdCustomer($emailConfirmationRequestTransfer->getIdCustomer());
            $customer->setEmail($entity->getNewEmail());
            $customer->save();
            $entity->delete();
        }

        return $response;
    }
}
