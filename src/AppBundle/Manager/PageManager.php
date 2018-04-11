<?php

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PageManager
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
}