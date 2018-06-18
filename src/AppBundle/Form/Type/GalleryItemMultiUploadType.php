<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\GalleryItem;
use AppBundle\Form\DataTransformer\GalleryItemTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryItemMultiUploadType extends AbstractType
{

    /** @var GalleryItemTransformer */
    protected $transformer;

    /**
     * MultiUploadType constructor.
     *
     * @param GalleryItemTransformer $transformer
     */
    public function __construct(GalleryItemTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this->transformer);
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required'   => false,
            'compound'   => false,
            'mapped'     => true,
            'data_class' => null
        ]);
    }

    public function getName()
    {
        return self::class;
    }
}
