# NaviappsFOSUserBundle

NaviappsFOSUserBundle provides a facility for building and handling multi-step forms in your FOSUserBundle project.<br>
use [CraueFormFlowBundle](https://github.com/craue/CraueFormFlowBundle);

## Setup

```
composer require naviapps/fos-user-bundle
```

app/AppKernel.php

``` php
public function registerBundles()
{
    $bundles = [
        // ...
        new FOS\UserBundle\FOSUserBundle(),
        new Craue\FormFlowBundle\CraueFormFlowBundle(),
        new Naviapps\Bundle\FOSUserBundle\NaviappsFOSUserBundle(),
    ];

    // ...
}
```

## Overriding a Form Flow and Form Type

RegistrationFlow.php

```php
<?php
// src/AppBundle/Form/RegistrationFlow.php

namespace AppBundle\Form;

use Naviapps\Bundle\FOSUserBundle\Form\Flow\RegistrationFormFlow as BaseFormFlow;

class RegistrationFlow extends BaseFormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array_merge(parent::loadStepsConfig(), [
            [
                'label' => 'confirmation',
            ],
        ]);
    }
}
```

services.yml

``` yaml
# app/config/services.yml
services:
    AppBundle\Form\RegistrationFlow:
        parent: craue.form.flow
        autowire: false
        autoconfigure: false
        public: true
```

config.yml

```yaml
# app/config/config.yml
naviapps_fos_user:
    # ...
    registration:
        form:
            flow: AppBundle\Form\RegistrationFlow
```
