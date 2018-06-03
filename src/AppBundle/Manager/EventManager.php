<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventManager
{
    /** @var RegistryInterface */
    protected $registry;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * PageController constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
        $this->em = $registry->getManager();
    }

    public function getEvent($slug)
    {
        return $this->em->getRepository(Event::class)->findOneBy(['slug' => $slug]);
    }
}