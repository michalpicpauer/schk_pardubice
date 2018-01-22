<?php

namespace AppBundle\Admin;

use Sonata\MediaBundle\Admin\ORM\MediaAdmin as Admin;

class MediaAdmin extends Admin
{
    const ROUTE = 'media';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'AdminBundle:CRUD:media_list.html.twig';
                break;
            case 'outer_list_rows_mosaic':
                return 'AdminBundle:CRUD:list_outer_rows_mosaic.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
