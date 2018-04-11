<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Page;
use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    /**
     * Returns page object of dashboard type or null.
     *
     * @return Page|null
     */
    public function findHomePage()
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->where('p.type = :value')->setParameter('value', Page::TYPE_HOMEPAGE)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getResult()[0] ?? null;
    }
}
