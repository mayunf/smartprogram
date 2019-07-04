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
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param array $params
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function modify(array $params)
    {
        return $this->httpPostJson('wxa/modify_domain', $params);
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
        return $this->httpPostJson('wxa/setwebviewdomain', [
            'action' => $action,
            'webviewdomain' => $domains,
        ]);
    }
}
