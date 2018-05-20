<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Page;
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

    /**
     * Returns all page objects not the event type.
     *
     * @return Page|null
     */
    public function getAll()
    {
        return $this->em->getRepository(Page::class)->findAllPages();
    }

    /**
     * Returns page object for homepage.
     *
     * @return Page|null
     */
    public function getHomepage()
    {
        return $this->em->getRepository(Page::class)->findHomePage();
    }

    /**
     * @return Page|null
     */
    public function getPage(string $slug): ?Page
    {
        return $this->em->getRepository(Page::class)->findOneBy(['slug' => $slug]);
    }
}