<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\NewsBundle\Entity\BaseComment;
use Sonata\NewsBundle\Model\PostInterface;

/**
 * @ORM\Entity()
 */
class Comment extends BaseComment
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var PostInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
