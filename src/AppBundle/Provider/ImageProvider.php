<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Provider;

use Sonata\CoreBundle\Model\Metadata;
use Sonata\MediaBundle\Provider\ImageProvider as BaseImageProvider;

class ImageProvider extends BaseImageProvider
{
    /**
     * @var bool
     */
    protected $multiUpload = false;

    public function getMultiUpload()
    {
        return $this->multiUpload;
    }

    public function setMultiUpload(bool $multiUpload)
    {
        $this->multiUpload = $multiUpload;

        return $this;
    }
}
