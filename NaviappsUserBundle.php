<?php

namespace Naviapps\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NaviappsUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
