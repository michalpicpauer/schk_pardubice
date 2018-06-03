<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\ClassificationBundle\Model\CollectionInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostManager
{
    /** @var RegistryInterface */
    protected $registry;

    /** @var EntityManagerInterface */
    protected $em;

    protected $postManager;

    /**
     * PageController constructor.
     * @param RegistryInterface                     $registry
     * @param \Sonata\NewsBundle\Entity\PostManager $postManager
     */
    public function __construct(RegistryInterface $registry, \Sonata\NewsBundle\Entity\PostManager $postManager)
    {
        $this->registry = $registry;
        $this->em = $registry->getManager();
        $this->postManager = $postManager;
    }

    /**
     * Returns specific amount of news or new posts for homepage.
     *
     * @param int $amount
     * @return Post[]
     */
    public function getNewsForHomepage(int $amount = 5)
    {
        return $this->em->getRepository(Post::class)->findNews($amount);
    }

    /**
     * Returns specific amount of news or new posts for homepage.
     *
     * @param CollectionInterface[] $collections
     * @param int                   $from
     * @param int                   $amount
     *
     * @return Post[]
     */
    public function getPosts($collections, int $from = 0, int $amount = 5)
    {
        $collectionsArray = [];
        foreach ($collections as $collection) {
            $collectionsArray[] = $collection->getId();
        }

        return $this->em->getRepository(Post::class)->findPosts($collectionsArray, $from, $amount);
    }

    public function getPost($collection, $slug)
    {
        return $this->em->getRepository(Post::class)->findPost($collection, $slug);
    }
}