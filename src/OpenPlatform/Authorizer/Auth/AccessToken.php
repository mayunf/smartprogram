<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\Auth;

use EasyBaiDu\Kernel\AccessToken as BaseAccessToken;
use EasyBaiDu\OpenPlatform\Application;
use Pimple\Container;

/**
 * Class AccessToken.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @var string
     */
    protected $queryName = 'access_token';

    /**
     * {@inheritdoc}.
     */
    protected $tokenKey = 'access_token';

    /**
     * @var \EasyBaiDu\OpenPlatform\Application
     */
    protected $component;

    /**
     * AuthorizerAccessToken constructor.
     *
     * @param \Pimple\Container                    $app
     * @param \EasyBaiDu\OpenPlatform\Application $component
     */
    public function __construct(Container $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

    /**
     * {@inheritdoc}.
     */
    protected function getCredentials(): array
    {
        return [
//            'refresh_token' => $this->app['config']['refresh_token'],
            'grant_type' => 'app_to_tp_authorization_code',
            'code' => $this->app['config']['refresh_token'],
            'access_token' => $this->component['access_token']->getToken()['access_token']
//            'app_id' => $this->app['config']['app_id'],
//            'access_token' => $this->component['access_token']->getToken()['access_token']
        ];
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return 'rest/2.0/oauth/token';
//        return 'rest/2.0/oauth/token'.http_build_query([
//            'access_token' => $this->component['access_token']->getToken()['access_token'],
////            'refresh_token' => $this->app['config']['refresh_token'],
//        ]);
    }
    public function getCacheKey()
    {
//        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
        return $this->cachePrefix.$this->app['config']['mina_app_id'];
    }
}
