<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\BasicService\ContentSecurity;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author tianyong90 <412039588@qq.com>
 */
class Client extends BaseClient
{
    /**
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com/wxa/';

    /**
     * Text content security check.
     *
     * @param string $text
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function checkText(string $text)
    {
        $params = [
            'content' => $text,
        ];

        return $this->httpPostJson('msg_sec_check', $params);
    }

    /**
     * Image security check.
     *
     * @param string $path
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function checkImage(string $path)
    {
        return $this->httpUpload('img_sec_check', ['media' => $path]);
    }
}
