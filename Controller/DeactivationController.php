<?php

namespace Naviapps\Bundle\UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Naviapps\Bundle\UserBundle\NaviappsUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller managing the deactivation
 *
 * @author Haruki Fukui <haruki.fukui@naviapps.com>
 */
class DeactivationController extends Controller
{
    public function deactivateAction(Request $request)
    {
        /** @var $flow \Craue\FormFlowBundle\Form\FormFlowInterface */
        $flow = $this->get('naviapps_user.deactivation.form.flow');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $this->getUser();
        $user->setEnabled(false);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $flow->bind($user);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $response = $this->redirectToRoute('fos_user_security_logout');
                }

                $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                $flow->reset(); // remove step data from the session

                return $response;
            }
        }

        return $this->render('NaviappsUserBundle:Deactivation:deactivate.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
}
