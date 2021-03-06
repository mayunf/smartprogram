<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Auth;

use EasyBaiDu\Kernel\AccessToken as BaseAccessToken;

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
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $endpointToGetToken = 'public/2.0/smartapp/auth/tp/token';

    /**
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'client_id' => $this->app['config']['app_id'],
            'ticket' => $this->app['verify_ticket']->getTicket(),
        ];
    }
    public function getCacheKey()
    {
//        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
        return $this->cachePrefix.$this->app['config']['app_id'];
    }
}

