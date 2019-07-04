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
 * @property \EasyBaiDu\MiniProgram\DataCube\Client            $data_cube
 * @property \EasyBaiDu\MiniProgram\AppCode\Client             $app_code
 * @property \EasyBaiDu\MiniProgram\Auth\Client                $auth
 * @property \EasyBaiDu\OfficialAccount\Server\Guard           $server
 * @property \EasyBaiDu\MiniProgram\Encryptor                  $encryptor
 * @property \EasyBaiDu\MiniProgram\TemplateMessage\Client     $template_message
 * @property \EasyBaiDu\OfficialAccount\CustomerService\Client $customer_service
 * @property \EasyBaiDu\MiniProgram\Plugin\Client              $plugin
 * @property \EasyBaiDu\MiniProgram\UniformMessage\Client      $uniform_message
 * @property \EasyBaiDu\MiniProgram\ActivityMessage\Client     $activity_message
 * @property \EasyBaiDu\MiniProgram\Express\Client             $logistics
 * @property \EasyBaiDu\MiniProgram\NearbyPoi\Client           $nearby_poi
 * @property \EasyBaiDu\MiniProgram\OCR\Client                 $ocr
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
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        ActivityMessage\ServiceProvider::class,
        OpenData\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        Base\ServiceProvider::class,
        Express\ServiceProvider::class,
        NearbyPoi\ServiceProvider::class,
        OCR\ServiceProvider::class,
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
