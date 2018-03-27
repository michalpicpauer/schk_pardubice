<?php

namespace AppBundle\Admin;

use Sonata\ClassificationBundle\Admin\TagAdmin as BaseTagAdmin;

class TagAdmin extends BaseTagAdmin
{
    const ROUTE = 'category';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;
}
