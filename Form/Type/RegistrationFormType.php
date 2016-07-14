<?php

namespace Naviapps\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    private $class;
    private $validationGroups;

    /**
     * @param string $class The User class name
     * @param array $validationGroups
     */
    public function __construct($class, array $validationGroups)
    {
        $this->class = $class;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add('email', EmailType::class, ['label' => 'form.email', 'translation_domain' => 'FOSUserBundle'])
                    ->add('username', null, ['label' => 'form.username', 'translation_domain' => 'FOSUserBundle'])
                    ->add('plainPassword', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'options' => ['translation_domain' => 'FOSUserBundle'],
                        'first_options' => ['label' => 'form.password'],
                        'second_options' => ['label' => 'form.password_confirmation'],
                        'invalid_message' => 'fos_user.password.mismatch',
                    ])
                ;
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class,
            'csrf_token_id' => 'registration',
            'validation_groups' => $this->validationGroups,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'naviapps_user_registration';
    }
}
