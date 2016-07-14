<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\ResettingFormType;

class ResettingFormFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'resetting',
                'form_type' => ResettingFormType::class,
            ],
        ];
    }
}
