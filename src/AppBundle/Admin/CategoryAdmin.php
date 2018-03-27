<?php

namespace AppBundle\Admin;

use Sonata\ClassificationBundle\Admin\CategoryAdmin as BaseCategoryAdmin;

class CategoryAdmin extends BaseCategoryAdmin
{
    const ROUTE = 'category';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;
}
