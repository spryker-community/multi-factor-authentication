<?php

namespace Pyz\Yves\MultiFactorAuthentication\Form;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;

class FormFactory extends AbstractFactory
{
    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getConfirmSecondFactorForm()
    {
        return $this->getFormFactory()->create(ConfirmSecondFactorForm::class);
    }
}
