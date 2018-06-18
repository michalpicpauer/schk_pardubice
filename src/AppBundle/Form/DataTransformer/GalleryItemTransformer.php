<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\GalleryItem;
use AppBundle\Entity\Media;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class GalleryItemTransformer
 */
class GalleryItemTransformer implements DataTransformerInterface
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * GalleryItemTransformer constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function reverseTransform($data)
    {
        $result = [];

        foreach (json_decode($data) as $mediaId => $id) {
            if ($id == 'unknown') {
                $m = $this->registry->getManager()->getRepository(Media::class)->find($mediaId);
                $galleryItem = new GalleryItem();
                $galleryItem->setMedia($m);
            } else {
                $galleryItem = $this->registry->getManager()->getRepository(GalleryItem::class)->find($id);
            }

            if (null === $galleryItem) {
                throw new TransformationFailedException(sprintf(
                    'The gallery item with id "%s" does not exist!',
                    $id
                ));
            }

            $result[] = $galleryItem;
        }

        return $result;
    }

    public function transform($data)
    {
        $result = [];
        /** @var GalleryItem $item */
        foreach ($data as $item) {
            $result[$item->getMedia()->getId()] = $item->getId();
        }

        return json_encode($result);
    }
}
