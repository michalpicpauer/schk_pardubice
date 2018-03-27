<?php

namespace AppBundle\Admin;

use Sonata\NewsBundle\Admin\CommentAdmin as BaseCommentAdmin;

class CommentAdmin extends BaseCommentAdmin
{
    const ROUTE = 'comment';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;
}
