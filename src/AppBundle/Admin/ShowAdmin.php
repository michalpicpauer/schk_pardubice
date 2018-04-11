<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Collection;
use AppBundle\Entity\Page;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShowAdmin extends BaseAdmin
{
    const ROUTE = 'show';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery();

        $alias = $query->getRootAliases()[0];

        $query->where($query->expr()->eq($alias . '.type', $query->expr()->literal('show')));

        return $query;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Show page')
            ->add('name')
//            ->add('title', TextType::class, [
//                'label' => 'form.title'
//            ])
//            ->add('subtitle', TextType::class, [
//                'label' => 'form.subtitle'
//            ])
//            ->add('content', FormatterType::class, [
//                'label'                  => 'form.content',
//                'required'               => false,
//                'event_dispatcher'       => $form->getFormBuilder()->getEventDispatcher(),
//                'format_field'           => 'contentFormatter',
//                'source_field'           => 'rawContent',
//                'target_field'           => 'content',
//                'ckeditor_toolbar_icons' => $this->getCkEditorToolbarIcons()
//            ])
//            ->add('galleries', ModelAutocompleteType::class, [
//                'property' => 'name',
//                'multiple' => 'true',
//                'minimum_input_length' => 1,
//                'required' => false,
//            ])
//            ->add('mainImage', ModelListType::class, [
//                'required' => false,
//            ], [
//                'link_parameters' => [
//                    'provider' => 'sonata.media.provider.image',
//                    'context'  => 'pages',
//                ],
//            ])
            ->end();
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

    /**
     * @param Page $object
     */
    public function prePersist($object)
    {
        $object->setType('show');
    }
}
