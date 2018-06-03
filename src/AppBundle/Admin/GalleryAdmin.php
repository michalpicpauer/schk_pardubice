<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\MediaBundle\Admin\GalleryAdmin as Admin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GalleryAdmin extends Admin
{
    const ROUTE = 'gallery';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->with('Gallery', ['class' => 'col-md-9'])->end()
            ->with('Options', ['class' => 'col-md-3'])->end()
        ;

        $context = $this->getPersistentParameter('context');

        if (!$context) {
            $context = $this->pool->getDefaultContext();
        }

        $formats = [];
        foreach ((array) $this->pool->getFormatNamesByContext($context) as $name => $options) {
            $formats[$name] = $name;
        }

        $contexts = [];
        foreach ((array) $this->pool->getContexts() as $contextItem => $format) {
            $contexts[$contextItem] = $contextItem;
        }

        $formMapper
            ->with('Options')
            ->add('context', ChoiceType::class, ['choices' => $contexts])
            ->add('enabled', null, ['required' => false])
            ->add('name')
            ->ifTrue(!empty($formats))
            ->add('defaultFormat', ChoiceType::class, ['choices' => $formats])
            ->ifEnd()
            ->end()
            ->with('Gallery')
            ->add('galleryHasMedias', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                'link_parameters' => ['context' => $context],
                'admin_code' => 'sonata.media.admin.gallery_has_media',
            ])
            ->end()
        ;
    }
}
