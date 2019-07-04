<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Code;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 为授权的小程序帐号上传小程序代码
     * @param int    $templateId
     * @param string $extJson
     * @param string $version
     * @param string $description
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function commit(int $templateId, string $extJson, string $version, string $description)
    {
        return $this->httpPostJson('rest/2.0/smartapp/package/upload', [
            'template_id' => $templateId,
            'ext_json' => $extJson,
            'user_version' => $version,
            'user_desc' => $description,
        ]);
    }


    /**
     * 为授权的小程序提交审核
     * @param string $content 送审描述
     * @param string $package_id 代码包id
     * @param string $remark 备注
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function submitAudit(string $content, string $package_id, string $remark)
    {
        return $this->httpPostJson('rest/2.0/smartapp/package/submitaudit', [
            'content' => $content,
            'package_id' => $package_id,
            'remark' => $remark,
        ]);
    }


    /**
     * 发布已通过审核的小程序
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function release(string $package_id)
    {
        return $this->httpPostJson('rest/2.0/smartapp/package/release', [
            'package_id' => $package_id
        ]);
    }


    /**
     * 小程序版本回退
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function rollbackRelease(string $package_id)
    {
        return $this->httpGet('rest/2.0/smartapp/package/rollback', [
            'package_id' => $package_id
        ]);
    }

    /**
     * 小程序审核撤回
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function withdrawAudit(string $package_id)
    {
        return $this->httpGet('rest/2.0/smartapp/package/withdraw', [
            'package_id' => $package_id
        ]);
    }

    /**
     * 获取授权小程序预览包详情
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getTrial()
    {
        return $this->httpGet('rest/2.0/smartapp/package/gettrial');
    }


    /**
     * 获取小程序包列表
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getPackage()
    {
        return $this->httpGet('rest/2.0/smartapp/package/get');
    }

    /**
     * 获取授权小程序包详情
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getDetail($type = '', $package_id = '')
    {
        return $this->httpGet('rest/2.0/smartapp/package/getdetail', [
            'type' => $type,
            'package_id' => $package_id,
        ]);
    }


    /** 以下API无用 **/

    /**
     * @param string|null $path
     *
     * @return \EasyBaiDu\Kernel\Http\Response
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getQrCode(string $path = null)
    {
        return $this->requestRaw('wxa/get_qrcode', 'GET', [
            'query' => ['path' => $path],
        ]);
    }

    /**
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getCategory()
    {
        return $this->httpGet('wxa/get_category');
    }

    /**
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getPage()
    {
        return $this->httpGet('wxa/get_page');
    }


    /**
     * @param int $auditId
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getAuditStatus(int $auditId)
    {
        return $this->httpPostJson('wxa/get_auditstatus', [
            'auditid' => $auditId,
        ]);
    }

    /**
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getLatestAuditStatus()
    {
        return $this->httpGet('wxa/get_latest_auditstatus');
    }





    /**
     * @param string $action
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function changeVisitStatus(string $action)
    {
        return $this->httpPostJson('wxa/change_visitstatus', [
            'action' => $action,
        ]);
    }

    /**
     * 分阶段发布.
     *
     * @param int $grayPercentage
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function grayRelease(int $grayPercentage)
    {
        return $this->httpPostJson('wxa/grayrelease', [
            'gray_percentage' => $grayPercentage,
        ]);
    }

    /**
     * 取消分阶段发布.
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function revertGrayRelease()
    {
        return $this->httpGet('wxa/revertgrayrelease');
    }

    /**
     * 查询当前分阶段发布详情.
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getGrayRelease()
    {
        return $this->httpGet('wxa/getgrayreleaseplan');
    }

    /**
     * 查询当前设置的最低基础库版本及各版本用户占比.
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getSupportVersion()
    {
        return $this->httpPostJson('cgi-bin/wxopen/getweappsupportversion');
    }

    /**
     * 设置最低基础库版本.
     *
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function setSupportVersion(string $version)
    {
        return $this->httpPostJson('cgi-bin/wxopen/setweappsupportversion', [
            'version' => $version,
        ]);
    }
}
