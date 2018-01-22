<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity\Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Page extends BaseEntity
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=125)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="content_formatter", type="string", nullable=true)
     */
    protected $contentFormatter;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     */
    public function setRawContent(string $rawContent)
    {
        $this->rawContent = $rawContent;
    }

    /**
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param string $contentFormatter
     */
    public function setContentFormatter(string $contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    function __toString()
    {
        if (empty($this->getName())) {
            return 'Nová stránka';
        }

        return $this->getName();
    }
}