<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Base;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get authorization info.
     *
     * @param string|null $authCode
     *
     * @return mixed
     */
    public function handleAuthorize(string $authCode = null)
    {
        $params = [
            'code' => $authCode ?? $this->app['request']->get('authorization_code'),
            'grant_type' => 'app_to_tp_authorization_code',
        ];

        return $this->httpGet('rest/2.0/oauth/token', $params);
    }

    /**
     * Get authorizer info.
     *
     * @param string $accessToken 	授权小程序的接口调用凭据
     *
     * @return mixed
     */
    public function getAuthorizer(string $accessToken)
    {
        $params = [
            'access_token' => $accessToken,
        ];

        return $this->httpGet('rest/2.0/smartapp/app/info', $params);
    }

    public function retrieveAuthcode (string $appId)
    {
        $params = [
            'app_id' => $appId
        ];
        return $this->httpPost('rest/2.0/smartapp/auth/retrieve/authorizationcode', $params);
    }

    /**
     * Create pre-authorization code.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     */
    public function createPreAuthorizationCode()
    {
        return $this->httpGet('rest/2.0/smartapp/tp/createpreauthcode');
    }

}
