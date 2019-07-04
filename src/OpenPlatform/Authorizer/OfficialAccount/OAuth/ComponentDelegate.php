<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\OfficialAccount\OAuth;

use EasyBaiDu\OpenPlatform\Application;
use Overtrue\Socialite\WeChatComponentInterface;

/**
 * Class ComponentDelegate.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class ComponentDelegate implements WeChatComponentInterface
{
    /**
     * @var \EasyBaiDu\OpenPlatform\Application
     */
    protected $app;

    /**
     * ComponentDelegate Constructor.
     *
     * @param \EasyBaiDu\OpenPlatform\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->app['config']['app_id'];
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->app['access_token']->getToken()['component_access_token'];
    }
}
