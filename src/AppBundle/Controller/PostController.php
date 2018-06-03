<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Manager\PageManager;
use AppBundle\Manager\PostManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /** @var PostManager */
    protected $postManager;

    /**
     * PageController constructor.
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }


    /**
     * @Route("/prispevky/{collection}/{slug}", name="post")
     *
     * @param string $collection
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction($collection, $slug)
    {
        $post = $this->postManager->getPost($collection, $slug);

        // replace this example code with whatever you need
        return $this->render('AppBundle:client/pages:post.html.twig', [
            'post'       => $post
        ]);
    }
}
