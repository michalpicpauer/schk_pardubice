<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Entity\Member
 *
 * @ORM\Entity()
 * @ORM\Table(name="`schk__member`")
 * @ORM\HasLifecycleCallbacks
 */
class Member extends BaseEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=125)
     */
    protected $name;

    /**
     * @var int
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    protected $position = 0;

    /**
     * @var string|null
     *
     * @ORM\Column(name="breed", type="text", nullable=true)
     */
    protected $breed;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cattery_name", type="text", nullable=true)
     */
    protected $catteryName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="web", type="string", nullable=true)
     */
    protected $web;

    /**
     * @var MediaInterface|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
     * @ORM\JoinColumn(name="main_image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $mainImage;

    /**
     * @var Page|null
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="members", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $page;

    public function __construct()
    {
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
     * @return null|string
     */
    public function getBreed(): ?string
    {
        return $this->breed;
    }

    /**
     * @param null|string $breed
     */
    public function setBreed(?string $breed): void
    {
        $this->breed = $breed;
    }

    /**
     * @return null|string
     */
    public function getCatteryName(): ?string
    {
        return $this->catteryName;
    }

    /**
     * @param null|string $catteryName
     */
    public function setCatteryName(?string $catteryName): void
    {
        $this->catteryName = $catteryName;
    }

    /**
     * @return null|string
     */
    public function getWeb(): ?string
    {
        return $this->web;
    }

    /**
     * @param null|string $web
     */
    public function setWeb(?string $web): void
    {
        $this->web = $web;
    }

    /**
     * @return null|MediaInterface
     */
    public function getMainImage(): ?MediaInterface
    {
        return $this->mainImage;
    }

    /**
     * @param null|MediaInterface $mainImage
     */
    public function setMainImage(?MediaInterface $mainImage): void
    {
        $this->mainImage = $mainImage;
    }

    /**
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * @param Page|null $page
     */
    public function setPage(?Page $page): void
    {
        $this->page = $page;
    }

    public function __toString()
    {
        if (empty($this->name)) {
            return 'Nová člen';
        }

        return $this->getName();
    }
}