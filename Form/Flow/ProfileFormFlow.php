<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\ProfileFormType;

class ProfileFormFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'profile',
                'form_type' => ProfileFormType::class,
            ],
        ];
    }
}
