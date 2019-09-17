<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\MiniProgram;

use EasyBaiDu\BasicService;
use EasyBaiDu\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \EasyBaiDu\MiniProgram\Auth\AccessToken           $access_token
 * @property \EasyBaiDu\MiniProgram\Data\Client                $data
 * @property \EasyBaiDu\MiniProgram\AppCode\Client             $app_code
 * @property \EasyBaiDu\MiniProgram\Auth\Client                $auth
 * @property \EasyBaiDu\MiniProgram\Encryptor                  $encryptor
 * @property \EasyBaiDu\MiniProgram\TemplateMessage\Client     $template_message
 * @property \EasyBaiDu\BasicService\Media\Client              $media
 * @property \EasyBaiDu\BasicService\ContentSecurity\Client    $content_security
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Data\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        Base\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
        BasicService\ContentSecurity\ServiceProvider::class,
    ];

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}
