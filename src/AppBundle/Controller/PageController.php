<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Manager\PageManager;
use AppBundle\Manager\PostManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    /** @var PageManager */
    protected $pageManager;

    /** @var PostManager */
    protected $postManager;

    /**
     * PageController constructor.
     * @param PageManager $pageManager
     * @param PostManager $postManager
     */
    public function __construct(PageManager $pageManager, PostManager $postManager)
    {
        $this->pageManager = $pageManager;
        $this->postManager = $postManager;
    }


    /**
     * @Route("/", name="homepage")
     *
     * @param RegistryInterface $registry
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $homepage = $this->pageManager->getHomePage();
        $amountOfPosts = $homepage ? $homepage->getNumberOfNews() : null;

        // replace this example code with whatever you need
        return $this->render('AppBundle:client/pages:homepage.html.twig', [
            'tag'        => false,
            'collection' => false,
            'page'       => $homepage,
            'posts'      => $this->postManager->getNewsForHomepage($amountOfPosts)
        ]);
    }

    /**
     * @Route("/navigation", name="navigation")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderNavigationAction()
    {
        return $this->render('AppBundle:client:navigation.html.twig', [
            'pages' => $this->pageManager->getAll()
        ]);
    }

    /**
     * @Route("/{slug}", name="renderPage")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderPageAction(string $slug)
    {
        $page = $this->pageManager->getPage($slug);

        if ($page == null) {
            throw new NotFoundHttpException();
        }

        switch ($page->getType()) {
            case Page::TYPE_HOMEPAGE:
                return $this->redirectToRoute('homepage');
                break;
            case Page::TYPE_DEFAULT:
                return $this->renderDefault($page);
                break;
            case Page::TYPE_POSTS:
                return $this->renderPosts($page);
                break;
            case Page::TYPE_EVENTS:
                return $this->renderEvents($page);
                break;
            case Page::TYPE_CONTACT:
                return $this->renderContacts($page);
                break;
            case Page::TYPE_GALLERY:
                return $this->renderGallery($page);
                break;
            case Page::TYPE_MEMBERS:
                return $this->renderMembers($page);
                break;
            default:
                return $this->redirectToRoute('homepage');
        }
    }

    private function renderDefault(Page $page)
    {
        return $this->render('AppBundle:client/pages:default.html.twig', [
            'page' => $page
        ]);
    }

    private function renderPosts(Page $page)
    {
        return $this->render('AppBundle:client/pages:posts.html.twig', [
            'page'  => $page,
            'posts' => $this->postManager->getPosts($page->getCollections())
        ]);
    }

    private function renderEvents(Page $page)
    {
        return $this->render('AppBundle:client/pages:events.html.twig', [
            'page' => $page
        ]);
    }

    private function renderContacts(Page $page)
    {
        return $this->render('AppBundle:client/pages:contact.html.twig', [
            'page' => $page
        ]);
    }

    private function renderGallery(Page $page)
    {
        return $this->render('AppBundle:client/pages:galleries.html.twig', [
            'page' => $page
        ]);
    }

    private function renderMembers(Page $page)
    {
        return $this->render('AppBundle:client/pages:members.html.twig', [
            'page' => $page
        ]);
    }
}
