<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\OfficialAccount\MiniProgram;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author Keal <caiyuezhang@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 获取公众号关联的小程序.
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function list()
    {
        return $this->httpPostJson('cgi-bin/wxopen/wxamplinkget');
    }

    /**
     * 关联小程序.
     *
     * @param string $appId
     * @param bool   $notifyUsers
     * @param bool   $showProfile
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function link(string $appId, bool $notifyUsers = true, bool $showProfile = false)
    {
        $params = [
            'appid' => $appId,
            'notify_users' => (string) $notifyUsers,
            'show_profile' => (string) $showProfile,
        ];

        return $this->httpPostJson('cgi-bin/wxopen/wxamplink', $params);
    }

    /**
     * 解除已关联的小程序.
     *
     * @param string $appId
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function unlink(string $appId)
    {
        $params = [
            'appid' => $appId,
        ];

        return $this->httpPostJson('cgi-bin/wxopen/wxampunlink', $params);
    }
}
