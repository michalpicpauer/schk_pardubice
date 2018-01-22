<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;

abstract class BaseAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'created'
    ];

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
        unset($this->listModes['mosaic']);
    }

    public function getBatchActions()
    {
        return parent::getBatchActions();
    }

    protected function getImageFieldOptions($image)
    {
        $fileFieldOptions = ['required' => false];
        if ($image) {
            $container = $this->getConfigurationPool()->getContainer();
            $pr = $container->get('sonata.media.provider.image');
            $fileFieldOptions = ['required' => false];
            if ($webPath = $pr->generatePublicUrl($image, 'admin')) {
                $fileFieldOptions['help'] = '<img src="' . $webPath . '" class="admin-preview" />';
            }
        }

        return $fileFieldOptions;
    }

    protected function getImagePreview($media)
    {
        if ($media) {
            $container = $this->getConfigurationPool()->getContainer();
            $pr = $container->get('sonata.media.provider.image');
            if ($webPath = $pr->generatePublicUrl($media, 'admin')) {
                return '<img src="' . $webPath . '" class="admin-preview" />';
            }
        }

        return '';
    }



    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('created', 'doctrine_orm_datetime_range', [
                'label' => 'form.created',
                'field_type' => 'sonata_type_datetime_range_picker'
            ])
            ->add('updated', 'doctrine_orm_datetime_range', [
                'label' => 'form.updated',
                'field_type' => 'sonata_type_datetime_range_picker'
            ]);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->with('form.stats', ['class' => 'col-md-4'])
            ->add('created', null, ['label' => 'form.created'])
            ->add('updated', null, ['label' => 'form.updated'])
            ->end();
    }

    /**
     * Get default toolbar icons for CK editor.
     *
     * @return array
     */
    protected function getCkEditorToolbarIcons()
    {
        return [
            1 => [
                'Bold', 'Italic', 'Underline',
                '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                '-', 'Undo', 'Redo',
                '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                '-', 'Blockquote',
                '-', 'Image', 'Link', 'Unlink', 'Table'
            ],
            2 => [
                'Maximize', 'Format', 'Source'
            ]
        ];
    }

    /**
     * @param string $repositoryClass
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository(string $repositoryClass)
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($repositoryClass);
    }

    protected function getEntityManager(string $repositoryClass)
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($repositoryClass);
    }
}