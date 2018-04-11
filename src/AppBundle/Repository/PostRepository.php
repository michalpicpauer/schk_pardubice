<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * Returns page object of dashboard type or null.
     *
     * @return Post[]
     */
    public function findNews(int $amount = 5)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }
}
