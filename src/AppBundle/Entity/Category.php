<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\ClassificationBundle\Model\ContextInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category extends BaseCategory
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var CategoryInterface[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @var CategoryInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var ContextInterface
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Context")
     * @ORM\JoinColumn(name="context_id", referencedColumnName="id")
     */
    protected $context;

    /**
     * @var MediaInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $media;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
