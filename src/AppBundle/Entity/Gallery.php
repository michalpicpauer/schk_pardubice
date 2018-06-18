<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery;
use Sonata\MediaBundle\Model\GalleryHasMediaInterface;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=125, unique=true)
     */
    protected $slug;


    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="raw_content", type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content_formatter", type="string", nullable=true)
     */
    protected $contentFormatter;

    protected $enabled = true;


    /**
     * @var GalleryHasMediaInterface[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GalleryItem", mappedBy="gallery", cascade={"persist", "merge"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $galleryHasMedias;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param null|string $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return null|string
     */
    public function getContentFormatter(): ?string
    {
        return $this->contentFormatter;
    }

    /**
     * @param null|string $contentFormatter
     */
    public function setContentFormatter(?string $contentFormatter): void
    {
        $this->contentFormatter = $contentFormatter;
    }

    /**
     * @return null|string
     */
    public function getRawContent(): ?string
    {
        return $this->rawContent;
    }

    /**
     * @param null|string $rawContent
     */
    public function setRawContent(?string $rawContent): void
    {
        $this->rawContent = $rawContent;
    }
}
