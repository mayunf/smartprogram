<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Account;

use EasyBaiDu\OpenPlatform\Authorizer\Aggregate\Account\Client as BaseClient;

/**
 * Class Client.
 *
 * @author ClouderSky <clouder.flow@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 获取账号基本信息.
     */
    public function getBasicInfo()
    {
        return $this->httpGet('rest/2.0/smartapp/app/info');
    }

    /**
     * 暂停服务
     */
    public function pause()
    {
        return $this->httpPostJson('rest/2.0/smartapp/app/pause');
    }

    /**
     * 开启服务
     */
    public function resume()
    {
        return $this->httpPostJson('rest/2.0/smartapp/app/resume');
    }


    /**
     * 绑定熊掌号
     */
    public function bindXzh()
    {
        return $this->httpPost('rest/2.0/smartapp/promotion/bind/xzh');
    }

    /**
     * 设置web化开关
     */
    public function modifywebstatus(int $webStatus = 1)
    {
        $params = [
            'web_status' => $webStatus
        ];
        return $this->httpPost('rest/2.0/smartapp/app/modifywebstatus', $params);
    }

    /**
     * 提交sitemap
     * @param string $urlList url集合；上传级别上限，0：每天3000条，1：每天5000条 多个,分割
     * @param int $type 上传级别 0：周级别，一周左右生效；1：天级别，2~3天生效
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function sitemap(string $urlList, int $type = 1)
    {
        $params = [
            'type' => $type,
            'url_list' => $urlList
        ];
        return $this->httpPost('rest/2.0/smartapp/access/submit/sitemap',$params);
    }

    /**
     * 修改头像.
     *
     * @param string $mediaId 头像素材mediaId
     * @param int    $left    剪裁框左上角x坐标（取值范围：[0, 1]）
     * @param int    $top     剪裁框左上角y坐标（取值范围：[0, 1]）
     * @param int    $right   剪裁框右下角x坐标（取值范围：[0, 1]）
     * @param int    $bottom  剪裁框右下角y坐标（取值范围：[0, 1]）
     */
    public function updateAvatar(
        string $mediaId,
        float $left = 0,
        float $top = 0,
        float $right = 1,
        float $bottom = 1
    ) {
        $params = [
            'head_img_media_id' => $mediaId,
            'x1' => $left, 'y1' => $top, 'x2' => $right, 'y2' => $bottom,
        ];

        return $this->httpPostJson('cgi-bin/account/modifyheadimage', $params);
    }

    /**
     * 修改功能介绍.
     *
     * @param string $signature 功能介绍（简介）
     */
    public function updateSignature(string $signature)
    {
        $params = ['signature' => $signature];

        return $this->httpPostJson('cgi-bin/account/modifysignature', $params);
    }
}
