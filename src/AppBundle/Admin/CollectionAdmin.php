<?php

namespace AppBundle\Admin;

use Sonata\ClassificationBundle\Admin\CollectionAdmin as BaseCollectionAdmin;

class CollectionAdmin extends BaseCollectionAdmin
{
    const ROUTE = 'collection';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;
}
