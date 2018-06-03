<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * Returns posts objects of dashboard type or null.
     *
     * @param int $amount
     * @return Post[]
     */
    public function findNews(int $amount)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->orderBy('p.publicationDateStart', 'DESC')
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Returns page object of dashboard type or null.
     *
     * @param array $collections
     * @param int   $from
     * @param int   $amount
     *
     * @return Post[]
     */
    public function findPosts(array $collections, int $from, int $amount)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->leftJoin('p.collection', 'pc')
            ->where($qb->expr()->in('pc.id', ':collections'))
            ->orderBy('p.publicationDateStart', 'DESC')
            ->setParameter('collections', $collections)
            ->setFirstResult($from)
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    public function findPost(string $collection, string $slug)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->leftJoin('p.collection', 'pc')
            ->where($qb->expr()->in('pc.slug', ':collection'))
            ->andWhere($qb->expr()->in('p.slug', ':slug'))
            ->setParameter('collection', $collection)
            ->setParameter('slug', $slug)
            ->getQuery();

        return $query->getSingleResult();
    }
}
