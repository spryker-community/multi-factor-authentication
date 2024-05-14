<?php

namespace Pyz\Yves\MultiFactorAuthentication\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Pyz\Yves\MultiFactorAuthentication\MultiFactorAuthenticationFactory getFactory()
 * @method \Pyz\Yves\MultiFactorAuthentication\MultiFactorAuthenticationConfig getConfig()
 */
class ConfirmSecondFactorForm extends AbstractType
{
    /**
     * @var string
     */
    public const FORM_NAME = 'confirmSecondFactorForm';

    /**
     * @var string
     */
    public const FIELD_TOKEN = 'otp-token';

    /**
     * @var string
     */
    protected const VALIDATION_NOT_BLANK_MESSAGE = 'validation.not_blank';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return static::FORM_NAME;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setAction('');

        $this
            ->addTokenField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTokenField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_TOKEN, TextType::class, [
            'label' => 'OTP Token',
            'constraints' => [
                $this->createNotBlankConstraint(),
            ],
            'mapped' => false,
        ]);

        return $this;
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\NotBlank
     */
    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank(['message' => static::VALIDATION_NOT_BLANK_MESSAGE]);
    }
}
