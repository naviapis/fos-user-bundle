<?php

namespace Naviapps\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
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
                    ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
                    ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                    ->add('current_password', PasswordType::class, array(
                        'label' => 'form.current_password',
                        'translation_domain' => 'FOSUserBundle',
                        'mapped' => false,
                        'constraints' => new UserPassword(),
                    ))
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
            'csrf_token_id' => 'profile',
            'validation_groups' => $this->validationGroups,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'naviapps_user_profile';
    }
}
