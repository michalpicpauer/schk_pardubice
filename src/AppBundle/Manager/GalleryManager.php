<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Event;
use AppBundle\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GalleryManager
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
        return $this->em->getRepository(Gallery::class)->findOneBy(['slug' => $slug]);
    }
}