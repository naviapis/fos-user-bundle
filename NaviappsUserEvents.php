<?php

namespace Naviapps\Bundle\UserBundle;

/**
 * Contains all events thrown in the NaviappsUserBundle
 */
final class NaviappsUserEvents
{
    /**
     * The DEACTIVATION_INITIALIZE event occurs when the deactivation process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a FOS\UserBundle\Event\UserEvent instance.
     */
    const DEACTIVATION_INITIALIZE = 'naviapps_user.deactivation.initialize';

    /**
     * The DEACTIVATION_SUCCESS event occurs when the deactivation form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a FOS\UserBundle\Event\FormEvent instance.
     */
    const DEACTIVATION_SUCCESS = 'naviapps_user.deactivation.success';

    /**
     * The DEACTIVATION_COMPLETED event occurs after saving the user in the deactivation process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a FOS\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const DEACTIVATION_COMPLETED = 'naviapps_user.deactivation.completed';
}
