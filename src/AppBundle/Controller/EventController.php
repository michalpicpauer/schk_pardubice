<?php

namespace AppBundle\Controller;

use AppBundle\Manager\EventManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    /** @var EventManager */
    protected $eventManager;

    /**
     * PageController constructor.
     * @param EventManager $eventManager
     */
    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }


    /**
     * @Route("/udalost/{slug}", name="event")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function eventAction($slug)
    {
        $event = $this->eventManager->getEvent($slug);

        // replace this example code with whatever you need
        return $this->render('AppBundle:client/pages:event.html.twig', [
            'event'       => $event
        ]);
    }
}
