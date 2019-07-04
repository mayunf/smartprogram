<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Auth;

use EasyBaiDu\Kernel\BaseClient;
use EasyBaiDu\Kernel\ServiceContainer;
use EasyBaiDu\OpenPlatform\Application;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @var \EasyBaiDu\OpenPlatform\Application
     */
    protected $component;

    /**
     * Client constructor.
     *
     * @param \EasyBaiDu\Kernel\ServiceContainer  $app
     * @param \EasyBaiDu\OpenPlatform\Application $component
     */
    public function __construct(ServiceContainer $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

    /**
     * Get session info by code.
     *
     * @param string $code
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function session(string $code)
    {
        $params = [
            'appid' => $this->app['config']['app_id'],
            'js_code' => $code,
            'grant_type' => 'authorization_code',
            'component_appid' => $this->component['config']['app_id'],
            'component_access_token' => $this->component['access_token']->getToken()['component_access_token'],
        ];

        return $this->httpGet('sns/component/jscode2session', $params);
    }
}
