<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\MiniProgram\Plugin;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param string $appId
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function apply($appId)
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'apply',
            'plugin_appid' => $appId,
        ]);
    }

    /**
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function list()
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'list',
        ]);
    }

    /**
     * @param string $appId
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function unbind($appId)
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'unbind',
            'plugin_appid' => $appId,
        ]);
    }
}
