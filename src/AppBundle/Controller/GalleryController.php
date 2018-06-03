<?php

namespace AppBundle\Controller;

use AppBundle\Manager\GalleryManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{
    /** @var GalleryManager */
    protected $galleryManager;

    /**
     * PageController constructor.
     * @param GalleryManager $galleryManager
     */
    public function __construct(GalleryManager $galleryManager)
    {
        $this->galleryManager = $galleryManager;
    }


    /**
     * @Route("/galerie/{slug}", name="gallery")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function eventAction($slug)
    {
        $gallery = $this->galleryManager->getEvent($slug);

        // replace this example code with whatever you need
        return $this->render('AppBundle:client/pages:gallery.html.twig', [
            'gallery' => $gallery
        ]);
    }
}
