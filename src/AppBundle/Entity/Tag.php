<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag;
use Sonata\ClassificationBundle\Model\ContextInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag extends BaseTag
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
