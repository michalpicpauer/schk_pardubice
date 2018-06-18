<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Admin;

use Sonata\MediaBundle\Admin\GalleryHasMediaAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GalleryHasMediaAdmin extends Admin
{

    protected function configureFormFields(FormMapper $form)
    {
        $link_parameters = [];

        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', []);
        }

        if ($this->hasRequest()) {
            $context = $this->getRequest()->get('context', null);

            if (null !== $context) {
                $link_parameters['context'] = $context;
            }
        }

        $media = null;
        if ($this->getSubject()) {
            $media = $this->getSubject()->getMedia();
        }

        $form
            ->add('media', ModelListType::class, $this->getImageFieldOptions($media), [
                'link_parameters' => $link_parameters, 'admin_code' => 'admin.media',
            ])
            ->add('position', HiddenType::class)
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('media')
            ->add('gallery')
            ->add('position')
        ;
    }

    protected function getImageFieldOptions($image)
    {
        $fileFieldOptions = ['required' => false, 'btn_edit' => false];
        if ($image) {
            $container = $this->getConfigurationPool()->getContainer();
            $pr = $container->get('sonata.media.provider.image');
            $fileFieldOptions = ['required' => false, 'btn_edit' => false];
            if ($webPath = $pr->generatePublicUrl($image, 'admin')) {
                $fileFieldOptions['sonata_help'] = '<img src="' . $webPath . '" class="admin-preview" />';
            }
        }

        return $fileFieldOptions;
    }
}
