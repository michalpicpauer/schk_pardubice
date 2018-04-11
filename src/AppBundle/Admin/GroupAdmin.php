<?php
namespace AppBundle\Admin;

use Sonata\UserBundle\Admin\Model\GroupAdmin as BaseGroupAdmin;

class GroupAdmin extends BaseGroupAdmin
{
    const ROUTE = 'group';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    protected function configureBatchActions($actions)
    {
        return [];
    }
}
