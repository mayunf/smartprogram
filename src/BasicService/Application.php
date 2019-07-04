<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\BasicService;

use EasyBaiDu\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \EasyBaiDu\BasicService\Jssdk\Client           $jssdk
 * @property \EasyBaiDu\BasicService\Media\Client           $media
 * @property \EasyBaiDu\BasicService\QrCode\Client          $qrcode
 * @property \EasyBaiDu\BasicService\Url\Client             $url
 * @property \EasyBaiDu\BasicService\ContentSecurity\Client $content_security
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Jssdk\ServiceProvider::class,
        QrCode\ServiceProvider::class,
        Media\ServiceProvider::class,
        Url\ServiceProvider::class,
        ContentSecurity\ServiceProvider::class,
    ];
}
