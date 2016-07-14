# NaviappsUserBundle

* Deactivate
* Form Flow

## Setup

```
composer require naviapps/user-bundle
```

app/AppKernel.php

``` php
public function registerBundles()
{
    $bundles = [
        // ...
        new Naviapps\Bundle\UserBundle\NaviappsUserBundle(),
    ];

    // ...
}
```

app/config/routing.yml

``` yaml
naviapps_user_deactivation:
    resource: "@NaviappsUserBundle/Resources/config/routing/deactivation.xml"
    prefix:   /deactivate
```

## Customize

``` yaml
services:
    app.deactivation.form.flow:
        class: AppBundle\Form\Flow\DeactivationFormFlow
        parent: craue.form.flow

    app.deactivation.form.type:
        class: AppBundle\Form\Type\DeactivationFormType
        tags:
            - { name: form.type, alias: naviapps_user_registration }
        arguments: ["%fos_user.model.user.class%", "%naviapps_user.deactivation.form.validation_groups%"]
```


### TODO

* Resources/Deactivation/deactivate.html.twig
