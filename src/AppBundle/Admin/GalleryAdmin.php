<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryItem;
use AppBundle\Form\Type\GalleryItemMultiUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\MediaBundle\Admin\GalleryAdmin as Admin;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GalleryAdmin extends Admin
{
    const ROUTE = 'gallery';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * GalleryAdmin constructor.
     */
    public function __construct($code, $class, $baseControllerName, Pool $pool, RegistryInterface $registry)
    {
        parent::__construct($code, $class, $baseControllerName, $pool);

        $this->em = $registry->getEntityManager();
    }

    /**
     * @param Gallery $object
     */
    public function preUpdate($object)
    {
        // workaround because GalleryItem is not initialized
        $galleryItems = $this->em->getRepository(GalleryItem::class)->findBy(['gallery' => $this->getSubject()]);

        foreach ($galleryItems as $galleryItem) {
            if (!$object->getGalleryHasMedias()->contains($galleryItem)) {
                $this->em->remove($galleryItem);
            }
        }
    }

    protected function configureFormFields(FormMapper $form)
    {
        // todo temporary workaround for loading proper data
        $galleryItemData = [];
        if ($this->getSubject()) {
            $galleryItemData = $this->em->getRepository(GalleryItem::class)->findBy(['gallery' => $this->getSubject()]);
        }
        $form
            ->with('Gallery')
            ->add('name')
            ->add('content', FormatterType::class, [
                'required'               => false,
                'help'                   => 'gallery_content_help',
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'ckeditor_context'       => 'default',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add(
                'galleryHasMedias',
                GalleryItemMultiUploadType::class,
                ['data' => $galleryItemData]
            )
            ->end();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('multi_upload', 'multi-upload');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    protected function getCkEditorToolbarIcons()
    {
        return [
            1 => [
                'Bold',
                'Italic',
                'Underline',
                '-',
                'Cut',
                'Copy',
                'Paste',
                'PasteText',
                'PasteFromWord',
                '-',
                'Undo',
                'Redo',
                '-',
                'NumberedList',
                'BulletedList',
                '-',
                'Outdent',
                'Indent',
                '-',
                'Blockquote',
                '-',
                'Image',
                'Link',
                'Unlink',
                'Table'
            ],
            2 => [
                'Maximize',
                'Format',
                'Source'
            ]
        ];
    }
}
