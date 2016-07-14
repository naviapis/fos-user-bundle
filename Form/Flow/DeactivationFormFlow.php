<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\DeactivationFormType;

class DeactivationFormFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'deactivation',
                'form_type' => DeactivationFormType::class,
            ],
        ];
    }
}
