<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Page;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PageAdmin extends BaseAdmin
{
    const ROUTE = 'page';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'ASC',
        '_sort_by'    => 'position',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
    }

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery();

        $alias = $query->getRootAliases()[0];

        $query->where($query->expr()->neq($alias . '.type', $query->expr()->literal(Page::TYPE_EVENT)));

        return $query;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $pageType = $this->getSubject()->getType() ?? $this->getPersistentParameters()['page_type'];
        switch ($pageType) {
            case Page::TYPE_HOMEPAGE:
                $this->buildHomePageForm($form);
                break;
            case Page::TYPE_POSTS:
                $this->buildPostsPageForm($form);
                break;
            case Page::TYPE_GALLERY:
                $this->buildGalleryPageForm($form);
                break;
            case Page::TYPE_CONTACT:
                $this->buildFullPageForm($form);
                break;
            case Page::TYPE_EVENTS:
                $this->buildEventsPageForm($form);
                break;
            default:
                $this->buildFullPageForm($form);
        }
    }

    protected function configureListFields(ListMapper $list)
    {


        $list
            ->addIdentifier('name', null, ['label' => 'form.name'])
            ->add('type', null, ['label' => 'form.type']);

        parent::configureListFields($list);

        $list
            ->remove('_action')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => [],
                    'delete' => [],
                    'move'   => [
                        'template' => '@PixSortableBehavior/Default/_sort_drag_drop.html.twig',
                        'enable_top_bottom_buttons' => false,
                    ]
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['label' => 'form.name']);

        parent::configureDatagridFilters($filter);
    }

    public function getPersistentParameters()
    {
        $params = parent::getPersistentParameters();

        if (strpos($this->getRequest()->get('_route'), 'list') == null) {
            $params['page_type'] = $this->getRequest()->get('page_type');
        }

        return $params;
    }

    public function getPageTypes()
    {
        return Page::getAllTypes();
    }

    /**
     * @param Page $object
     */
    public function prePersist($object)
    {
        $pageType = $this->getPersistentParameters()['page_type'];

        $object->setType($pageType);
    }

    private function buildFullPageForm(FormMapper $form)
    {
        $form
            ->with('Default page')
            ->add('name', TextType::class)
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class)
            ->add('content', FormatterType::class, [
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('collections', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('galleries', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('events', CollectionType::class, [
                'by_reference' => false,
            ], [
                'edit'        => 'inline',
                'inline'      => 'table',
                'sortable'    => 'priority',
                'placeholder' => 'No events added'
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                ],
            ])
            ->end();
    }

    private function buildHomePageForm(FormMapper $form)
    {
        $form
            ->with('Homepage')
            ->add('name')
            ->add('title')
            ->add('subtitle')
            ->add('content', FormatterType::class, [
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('numberOfNews')
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                ],
            ])
            ->end();
    }

    private function buildPostsPageForm(FormMapper $form)
    {
        $form
            ->with('Posts page')
            ->add('name')
            ->add('title')
            ->add('subtitle', null, ['required' => false])
            ->add('collections', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                ],
            ])
            ->end();
    }

    private function buildGalleryPageForm(FormMapper $form)
    {
        $form
            ->with('Gallery page')
            ->add('name')
            ->add('title')
            ->add('subtitle')
            ->add('content', FormatterType::class, [
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('galleries', ModelAutocompleteType::class, [
                'property'             => 'name',
                'multiple'             => 'true',
                'minimum_input_length' => 1,
                'required'             => false,
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                ],
            ])
            ->end();
    }

    private function buildEventsPageForm(FormMapper $form)
    {
        $form
            ->with('Events page')
            ->add('name')
            ->add('title')
            ->add('subtitle')
            ->add('content', FormatterType::class, [
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('events', CollectionType::class, [
                'by_reference' => false,
            ], [
                'edit'        => 'inline',
                'inline'      => 'table',
                'sortable'    => 'priority',
                'placeholder' => 'No events added'
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                ],
            ])
            ->end();
    }
}
