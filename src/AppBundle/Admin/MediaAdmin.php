<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as Admin;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MediaAdmin extends Admin
{
    const ROUTE = 'media';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

//    public function getTemplate($name)
//    {
//        switch ($name) {
//            case 'list':
//                return 'AdminBundle:CRUD:media_list.html.twig';
//                break;
//            case 'outer_list_rows_mosaic':
//                return 'AdminBundle:CRUD:list_outer_rows_mosaic.html.twig';
//                break;
//            default:
//                return parent::getTemplate($name);
//                break;
//        }
//    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('multi_upload', 'multi-upload');
        $collection->remove('edit');
        $collection->remove('show');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $media = $this->getSubject();

        if (!$media) {
            $media = $this->getNewInstance();
        }

        if (!$media || !$media->getProviderName()) {
            return;
        }

        $form->add('providerName', HiddenType::class);

        $form->getFormBuilder()->addModelTransformer(new ProviderDataTransformer($this->pool, $this->getClass()),
            true);

        $provider = $this->pool->getProvider($media->getProviderName());

        $provider->buildCreateForm($form);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('Preview', null, ['template' => 'AppBundle:admin/CRUD:list_image.html.twig'])
            ->add('name')
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => []
                ]
            ]);
    }
}
