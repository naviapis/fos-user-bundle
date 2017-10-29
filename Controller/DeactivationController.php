<?php

namespace Naviapps\Bundle\UserBundle\Controller;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Naviapps\Bundle\UserBundle\NaviappsUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        /** @var $flow FormFlowInterface */
        $flow = $this->get('naviapps_user.deactivation.form.flow');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $user->setEnabled(false);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $flow->bind($user);

        // form of the current step
        $form = $flow->createForm();
        if ($form->isSubmitted()) {
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
                        $url = $this->generateUrl('fos_user_security_logout');
                        $response = new RedirectResponse($url);
                    }

                    $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                    $flow->reset(); // remove step data from the session

                    return $response;
                }
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(NaviappsUserEvents::DEACTIVATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@NaviappsUser/Deactivation/deactivate.html.twig', [
            'form' => $form->createView(),
            'flow' => $flow,
        ]);
    }
}
