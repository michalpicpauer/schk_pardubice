<?php

namespace AppBundle\Admin;

use Sonata\MediaBundle\Admin\GalleryAdmin as Admin;

class GalleryAdmin extends Admin
{
    const ROUTE = 'gallery';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

}
