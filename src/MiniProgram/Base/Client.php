<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\MiniProgram\Base;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get paid unionid.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     */
    public function getPaidUnionid($openid, $options = [])
    {
        return $this->httpGet('wxa/getpaidunionid', compact('openid') + $options);
    }
}
