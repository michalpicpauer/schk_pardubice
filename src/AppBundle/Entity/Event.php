<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\ClassificationBundle\Model\CollectionInterface;
use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Entity\Event
 *
 * @ORM\Entity()
 * @ORM\Table(name="`schk__event`")
 * @ORM\HasLifecycleCallbacks
 */
class Event extends BaseEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=125)
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=125, unique=true)
     */
    protected $slug;

    /**
     * @var int
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="`from`", type="datetime")
     */
    protected $from;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="`to`", type="datetime")
     */
    protected $to;

    /**
     * @var string|null
     *
     * @ORM\Column(name="`place`", type="string", nullable=true)
     */
    protected $place;

    /**
     * @var MediaInterface|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinColumn(name="main_image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $mainImage;

    /**
     * @var Collection|GalleryInterface[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gallery")
     * @ORM\JoinTable(name="events_galleries",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $galleries;

    /**
     * @var Collection|GalleryInterface[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinTable(name="events_files",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $files;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="events", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $page;

    public function __construct()
    {
        $this->collections = new ArrayCollection();
        $this->galleries = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
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
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return \DateTime
     */
    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

    /**
     * @param \DateTime $from
     */
    public function setFrom(\DateTime $from): void
    {
        $this->from = $from;
    }

    /**
     * @return \DateTime
     */
    public function getTo(): ?\DateTime
    {
        return $this->to;
    }

    /**
     * @param \DateTime $to
     */
    public function setTo(\DateTime $to): void
    {
        $this->to = $to;
    }

    /**
     * @return null|string
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param null|string $place
     */
    public function setPlace(?string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return Collection|GalleryInterface[]
     */
    public function getFiles()
    {
        return $this->files;
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
     * @return MediaInterface|null
     */
    public function getMainImage(): ?MediaInterface
    {
        return $this->mainImage;
    }

    /**
     * @param MediaInterface $mainImage
     */
    public function setMainImage($mainImage): void
    {
        $this->mainImage = $mainImage;
    }

    /**
     * @return Collection|GalleryInterface[]
     */
    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * @param GalleryInterface $gallery
     */
    public function addGallery($gallery): void
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries[] = $gallery;
        }
    }

    /**
     * @param GalleryInterface $gallery
     */
    public function removeGallery($gallery): void
    {
        $this->galleries->removeElement($gallery);
    }

    /**
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage(Page $page): void
    {
        $this->page = $page;
    }

    public function __toString()
    {
        if (empty($this->name)) {
            return 'Nová událost';
        }

        return $this->getName();
    }
}