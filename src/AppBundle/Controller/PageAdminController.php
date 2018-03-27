<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;

class PageAdminController extends Controller
{

    public function preCreate(Request $request, $object)
    {
        $parameters = $this->admin->getPersistentParameters();
        if (!$parameters['page_type']) {
            return $this->renderWithExtraParams('AppBundle:admin/pages:select_page_type.html.twig', [
                'base_template' => $this->getBaseTemplate(),
                'admin'         => $this->admin,
                'action'        => 'create'
            ]);
        }

        return null;
    }
}