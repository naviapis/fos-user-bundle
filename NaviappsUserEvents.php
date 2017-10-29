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
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    const DEACTIVATION_INITIALIZE = 'naviapps_user.deactivation.initialize';

    /**
     * The DEACTIVATION_SUCCESS event occurs when the deactivation form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    const DEACTIVATION_SUCCESS = 'naviapps_user.deactivation.success';

    /**
     * The DEACTIVATION_FAILURE event occurs when the deactivation form is not valid.
     *
     * This event allows you to set the response instead of using the default one.
     *
     * @Event("FOS\UserBundle\Event\FormEvent")
     */
    const DEACTIVATION_FAILURE = 'naviapps_user.deactivation.failure';

    /**
     * The DEACTIVATION_COMPLETED event occurs after saving the user in the deactivation process.
     *
     * This event allows you to access the response which will be sent.
     *
     * @Event("FOS\UserBundle\Event\FilterUserResponseEvent")
     */
    const DEACTIVATION_COMPLETED = 'naviapps_user.deactivation.completed';
}
