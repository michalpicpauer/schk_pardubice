<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\MediaBundle\Entity\BaseMedia;
use Sonata\MediaBundle\Model\GalleryHasMediaInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 */
class Media extends BaseMedia
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
     * @var GalleryHasMediaInterface[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GalleryItem", mappedBy="media")
     */
    protected $galleryHasMedias;

    /**
     * @var CategoryInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
