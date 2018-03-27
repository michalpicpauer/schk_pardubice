<?php

namespace AppBundle\Admin;

use Sonata\ClassificationBundle\Admin\ContextAdmin as BaseContextAdmin;

class ContextAdmin extends BaseContextAdmin
{
    const ROUTE = 'context';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;
}
