<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ShowPageAdmin extends BaseAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('show', ModelListType::class, [
                'required' => false,
                'btn_delete' => false,
                'by_reference' => false,
            ], [
                'admin_code' => 'admin.show'
            ])
            ->add('priority', HiddenType::class);
    }

}
