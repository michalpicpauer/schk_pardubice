<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\ClassificationBundle\Model\CollectionInterface;
use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Entity\Page
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Page extends BaseEntity
{
    const TYPE_DEFAULT = 'default_page';
    const TYPE_HOMEPAGE = 'homepage';
    const TYPE_POSTS = 'posts_page';
    const TYPE_EVENTS = 'events_page';
    const TYPE_CONTACT = 'contact_page';
    const TYPE_GALLERY = 'gallery_page';
    const TYPE_EVENT = 'event';

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
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="subtitle", type="string", nullable=true)
     */
    protected $subtitle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number_of_news", type="integer", nullable=true)
     */
    protected $numberOfNews;

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
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    /**
     * @var MediaInterface|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinColumn(name="main_image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $mainImage;

    /**
     * @var Collection|CollectionInterface[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Collection")
     * @ORM\JoinTable(name="pages_collections",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $collections;

    /**
     * @var Collection|GalleryInterface[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gallery")
     * @ORM\JoinTable(name="pages_galleries",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $galleries;

    /**
     * @var Collection|PageEvent[]
     *
     * @ORM\OneToMany(targetEntity="PageEvent", mappedBy="page", cascade={"persist", "merge", "remove"})
     * @ORM\OrderBy({"priority" = "ASC"})
     */
    protected $events;

    public function __construct()
    {
        $this->collections = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param string|null $subtitle
     */
    public function setSubtitle($subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return int|null
     */
    public function getNumberOfNews(): ?int
    {
        return $this->numberOfNews;
    }

    /**
     * @param int|null $numberOfNews
     */
    public function setNumberOfNews(?int $numberOfNews): void
    {
        $this->numberOfNews = $numberOfNews;
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
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @return Collection|CollectionInterface[]
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @param CollectionInterface $collection
     */
    public function addCollection($collection): void
    {
        if (!$this->collections->contains($collection)) {
            $this->collections[] = $collection;
        }
    }

    /**
     * @param CollectionInterface $collection
     */
    public function removeCollection($collection): void
    {
        $this->collections->removeElement($collection);
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
     * @return Collection|PageEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param PageEvent $event
     */
    public function addEvent($event): void
    {
        if (!$this->events->contains($event)) {
            $event->setPage($this);
            $this->events[] = $event;
        }
    }

    /**
     * @param PageEvent $event
     */
    public function removeEvent($event): void
    {
        $this->events->removeElement($event);
    }

    public function __toString()
    {
        if (empty($this->name)) {
            return 'Nová stránka';
        }

        return $this->getName();
    }

    public static function getAllTypes()
    {
        return [
            self::TYPE_DEFAULT,
            self::TYPE_HOMEPAGE,
            self::TYPE_POSTS,
            self::TYPE_CONTACT,
            self::TYPE_EVENTS,
            self::TYPE_GALLERY,
        ];
    }
}