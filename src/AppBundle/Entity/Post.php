<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Model\CollectionInterface;
use Sonata\ClassificationBundle\Model\TagInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\NewsBundle\Entity\BasePost;
use Sonata\NewsBundle\Model\CommentInterface;
use Sonata\UserBundle\Model\UserInterface;

/**
 * @ORM\Entity()
 */
class Post extends BasePost
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
     * @var Collection|TagInterface[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag")
     * @ORM\JoinTable(name="posts_tags",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $tags;

    /**
     * @var Collection|CommentInterface[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="post")
     */
    protected $comments;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var MediaInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $image;

    /**
     * @var Collection|CollectionInterface[]
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Collection")
     * @ORM\JoinColumn(name="collection_id", referencedColumnName="id")
     */
    protected $collection;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
