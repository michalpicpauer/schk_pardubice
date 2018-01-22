<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryHasMedia;
use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryItemRepository")
 */
class GalleryItem extends BaseGalleryHasMedia
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
     * @var MediaInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", inversedBy="galleryHasMedias")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $media;

    /**
     * @var GalleryInterface
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Gallery", inversedBy="galleryHasMedias")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    protected $gallery;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
