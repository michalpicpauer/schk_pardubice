<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Collection;
use AppBundle\Entity\Event;
use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventAdmin extends BaseAdmin
{
    const ROUTE = 'event';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct($code, $class, $baseControllerName, RegistryInterface $registry)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->em = $registry->getManager();
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Event page')
            ->add('name')
            ->add('from', DatePickerType::class)
            ->add('to', DatePickerType::class)
            ->add('place', null, ['required' => false])
            ->add('content', FormatterType::class, [
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('galleries', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ], [
                'admin_code' => 'admin.gallery'
            ])
            ->add(
                'mainImage',
                ModelListType::class,
                $this->getImageFieldOptions($this->getSubject()->getMainImage()),
                [
                    'link_parameters' => [
                        'provider' => 'sonata.media.provider.image',
                        'context'  => 'default',
                    ],
                    'admin_code' => 'admin.media'
                ]
            )
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('from', 'date')
            ->add('to', 'date');

        parent::configureListFields($list);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name');

        parent::configureDatagridFilters($filter);
    }

    /**
     * @param Event $object
     */
    public function prePersist($object)
    {
        $membersPages = $this->em->getRepository(Page::class)->findBy(['type' => Page::TYPE_MEMBERS]);

        if (!empty($membersPages) && $object->getPage() == null) {
            $object->setPage($membersPages[0]);
        }
    }
}
