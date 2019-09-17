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

    public function modifyheadimage(string $imgurl)
    {
        return $this->httpPost('rest/2.0/smartapp/app/modifyheadimage',['image_url' => $imgurl]);
    }

    /**
     * 修改功能介绍.
     *
     * @param string $signature 功能介绍（简介）
     */
    public function updateSignature(string $signature)
    {
        $params = ['signature' => $signature];

        return $this->httpPost('rest/2.0/smartapp/app/modifysignature', $params);
    }

    /**
     * 修改小程序名称.
     *
     *param string $nickname 小程序名称
     */
    public function setNickname(string $nickname,string $img='')
    {
        $params = ['nick_name' => $nickname,'app_name_material'=>$img];

        return $this->httpPost('rest/2.0/smartapp/app/setnickname', $params);
    }

    /**
     * 小程序类目列表.
     *param int $category_type 1.个人类型类目 2.企业类型类目 为2时可以查出全部类目
     */
    public function categoryList($category_type = 2)
    {
        $params = ['category_type' => $category_type];
        return $this->httpGet('rest/2.0/smartapp/app/category/list',$params);
    }

    /**
     * 修改小程序类目.
     *
     *param string $categorys 类目类别json字符串
     */
    public function categoryUpdate(string $categorys)
    {
        $params = ['categorys' => $categorys];
        return $this->httpPost('/rest/2.0/smartapp/app/category/update', $params);
    }


    /**
     * 查询当前设置的最低基础库版本及各版本列表
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getSupportVersion()
    {
        return $this->httpGet('rest/2.0/smartapp/app/getsupportversion');
    }
}
