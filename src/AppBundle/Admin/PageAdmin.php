<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Page;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PageAdmin extends BaseAdmin
{
    const ROUTE = 'page';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery();

        $alias = $query->getRootAliases()[0];

        $query->where($query->expr()->neq($alias . '.type', $query->expr()->literal('show')));

        return $query;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $pageType = $this->getSubject()->getType() ?? $this->getPersistentParameters()['page_type'];
        switch ($pageType) {
            case Page::TYPE_DASHBOARD:
                $this->buildDefaultPageForm($form);
                break;
            case Page::TYPE_NEWS:
                $this->buildNewsPageForm($form);
                break;
            case Page::TYPE_GALLERY:
                $this->buildGalleryPageForm($form);
                break;
            case Page::TYPE_CONTACT:
                break;
            case Page::TYPE_SHOWS:
                $this->buildShowsPageForm($form);
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
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['label' => 'form.name']);

        parent::configureDatagridFilters($filter);
    }

//    protected function configureShowFields(ShowMapper $show)
//    {
//        $show
//            ->with('FormInfo', ['class' => 'col-md-8'])
//            ->add('name', null, ['label' => 'FormName'])
//            ->add('slug', null, ['label' => 'FormSlug'])
//            ->add('content', 'html', ['label' => 'FormContent'])
//            ->end();
//
//        parent::configureShowFields($show);
//    }

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
            ->add('name', TextType::class, [
                'label' => 'form.name'
            ])
            ->add('title', TextType::class, [
                'label' => 'form.title'
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'form.subtitle'
            ])
            ->add('content', FormatterType::class, [
                'label'                  => 'form.content',
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
            ->add('shows', CollectionType::class, [
                'label'        => 'hgu',
                'by_reference' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'priority',
                'placeholder' => 'No shows added'
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'pages',
                ],
            ])
            ->end();
    }

    private function buildDefaultPageForm(FormMapper $form)
    {
        $form
            ->with('Default page')
            ->add('name', TextType::class, [
                'label' => 'form.name'
            ])
            ->add('title', TextType::class, [
                'label' => 'form.title'
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'form.subtitle'
            ])
            ->add('content', FormatterType::class, [
                'label'                  => 'form.content',
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'pages',
                ],
            ])
            ->end();
    }

    private function buildNewsPageForm(FormMapper $form)
    {
        $form
            ->with('News page')
            ->add('name', TextType::class, [
                'label' => 'form.name'
            ])
            ->add('title', TextType::class, [
                'label' => 'form.title'
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'form.subtitle'
            ])
            ->add('collections', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => 'true',
                'minimum_input_length' => 1,
                'required' => false,
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'pages',
                ],
            ])
            ->end();
    }

    private function buildGalleryPageForm(FormMapper $form)
    {
        $form
            ->with('Gallery page')
            ->add('name', TextType::class, [
                'label' => 'form.name'
            ])
            ->add('title', TextType::class, [
                'label' => 'form.title'
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'form.subtitle'
            ])
            ->add('content', FormatterType::class, [
                'label'                  => 'form.content',
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('galleries', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => 'true',
                'minimum_input_length' => 1,
                'required' => false,
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'pages',
                ],
            ])
            ->end();
    }

    private function buildShowsPageForm(FormMapper $form)
    {
        $form
            ->with('Shows page')
            ->add('name', TextType::class, [
                'label' => 'form.name'
            ])
            ->add('title', TextType::class, [
                'label' => 'form.title'
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'form.subtitle'
            ])
            ->add('content', FormatterType::class, [
                'label'                  => 'form.content',
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->add('shows', CollectionType::class, [
                'label'        => 'hgu',
                'by_reference' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'priority',
                'placeholder' => 'No shows added'
            ])
            ->add('mainImage', ModelListType::class, [
                'required' => false,
            ], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'pages',
                ],
            ])
            ->end();
    }
}
