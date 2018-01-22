<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery;
use Sonata\MediaBundle\Model\GalleryHasMediaInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryRepository")
 */
class Gallery extends BaseGallery
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GalleryItem", mappedBy="gallery")
     */
    protected $galleryHasMedias;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
