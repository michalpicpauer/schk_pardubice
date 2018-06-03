<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\NewsBundle\Admin\PostAdmin as BasePostAdmin;
use Sonata\NewsBundle\Form\Type\CommentStatusType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends BasePostAdmin
{
    const ROUTE = 'post';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = 'horizontal' == $this->getConfigurationPool()->getOption('form_type');
        $formMapper
            ->with('group_post', [
                'class' => 'col-md-8',
            ])
            ->add(
                'author',
                ModelAutocompleteType::class,
                ['property' => 'username', 'minimum_input_length' => 0, 'required' => false]
            )
            ->add('title', TextType::class, ['label' => 'form.label_title'])
            ->add('abstract', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('content', FormatterType::class, [
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'contentFormatter',
                'source_field'         => 'rawContent',
                'source_field_options' => [
                    'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                    'attr'                           => [
                        'class' => $isHorizontal ? 'span10 col-sm-10 col-md-10' : '',
                        'rows'  => 20
                    ],
                ],
                'ckeditor_context'     => 'default',
                'target_field'         => 'content',
                'listener'             => true,
            ])
            ->end()
            ->with('group_status', [
                'class' => 'col-md-4',
            ])
            ->add('enabled', CheckboxType::class, ['required' => false])
            ->add(
                'image',
                ModelListType::class,
                $this->getImageFieldOptions($this->getSubject()->getImage()),
                [
                    'link_parameters' => [
                        'provider' => 'sonata.media.provider.image',
                        'context'  => 'default',
                    ],
                ]
            )
            ->add('publicationDateStart', DateTimePickerType::class, [
                'dp_side_by_side' => true,
            ])
            ->add('commentsCloseAt', DateTimePickerType::class, [
                'dp_side_by_side' => true,
                'required'        => false,
            ])
            ->add('commentsEnabled', CheckboxType::class, [
                'required' => false,
            ])
//            ->add('commentsDefaultStatus', CommentStatusType::class, [
//                'expanded' => true,
//                'required' => false,
//            ])
            ->end()
            ->with('group_classification', [
                'class' => 'col-md-4',
            ])
            ->add('tags', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('collection', ModelType::class, [
                'required' => false,
            ])
            ->end();
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
}
