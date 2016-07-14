<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\RegistrationFormType;

class RegistrationFormFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'registration',
                'form_type' => RegistrationFormType::class,
            ],
        ];
    }
}
