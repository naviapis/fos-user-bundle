<?php

namespace Naviapps\Bundle\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
use Naviapps\Bundle\UserBundle\Form\Type\ResettingFormType;

class ResettingFormFlow extends FormFlow
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type The type of the form
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'resetting',
                'form_type' => $this->type,
            ],
        ];
    }
}
