<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\ChangePasswordFormType;

class ChangePasswordFormFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'change_password',
                'form_type' => ChangePasswordFormType::class,
            ],
        ];
    }
}
