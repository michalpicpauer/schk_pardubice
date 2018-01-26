<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PageAdmin extends BaseAdmin
{
    const ROUTE = 'page';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('export');
    }

    protected function configureFormFields(FormMapper $form)
    {

        $form
            ->with('FormPage')
            ->add('name', TextType::class, [
                'label' => 'FormName'
            ])
            ->add('content', FormatterType::class, [
                'label'                  => 'FormContent',
                'required'               => false,
                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
                'format_field'           => 'contentFormatter',
                'source_field'           => 'rawContent',
                'target_field'           => 'content',
                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
            ])
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'FormName'])
            ->add('slug', null, ['label' => 'FormSlug'])
            ->add('created', null, ['label' => 'FormCreated'])
            ->add('updated', null, ['label' => 'FormUpdated'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['label' => 'FromName'])
            ->add('slug', null, ['label' => 'FormSlug']);

        parent::configureDatagridFilters($filter);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->with('FormInfo', ['class' => 'col-md-8'])
            ->add('name', null, ['label' => 'FormName'])
            ->add('slug', null, ['label' => 'FormSlug'])
            ->add('content', 'html', ['label' => 'FormContent'])
            ->end();

        parent::configureShowFields($show);
    }

}
