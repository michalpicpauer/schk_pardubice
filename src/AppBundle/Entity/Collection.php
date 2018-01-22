<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCollection;
use Sonata\ClassificationBundle\Model\ContextInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollectionRepository")
 */
class Collection extends BaseCollection
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
