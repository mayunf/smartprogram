<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Domain;

use EasyBaiDu\Kernel\BaseClient;

/**
 * 修改服务器地址
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 设置小程序服务器域名
     * @param array $params
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function modify(array $params)
    {
        return $this->httpPostJson('rest/2.0/smartapp/app/modifydomain', $params);
    }

    /**
     * 设置小程序业务域名.
     *
     * @param array  $domains
     * @param string $action
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function setWebviewDomain(array $domains, $action = 'add')
    {
        return $this->httpPostJson('rest/2.0/smartapp/app/modifywebviewdomain', [
            'action' => $action,
            'webviewdomain' => $domains,
        ]);
    }
}
