<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use AppBundle\Manager\PageManager;
use AppBundle\Repository\PageRepository;
use AppBundle\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /** @var PageManager */
    protected $pageManager;




    /**
     * @Route("/", name="homepage")
     *
     * @param RegistryInterface $registry
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $parameters = array_merge([
            'tag' => false,
            'collection' => false,
        ], $parameters);

        $pageRepository = $this->em->getRepository(Page::class);
        $postRepository = $this->em->getRepository(Post::class);
        $homepage = $pageRepository->findHomePage();

        $posts = $postRepository->findNews($homepage->getNumberOfNews());

        // replace this example code with whatever you need
        return $this->render('AppBundle:client/pages:homepage.html.twig', [
            'page'  => $homepage,
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/{$slug}", name="renderPage")
     *
     * @param RegistryInterface $registry
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderPageAction(RegistryInterface $request)
    {

    }
}
