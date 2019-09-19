<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Chain;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{

    /**
     * 添加子链
     * @link http://smartprogram.baidu.com/docs/develop/third/sitemap/#%E5%B0%8F%E7%A8%8B%E5%BA%8F%E5%8D%95%E5%8D%A1%E9%85%8D%E7%BD%AE
     * @param string $chainName 4-10个字符，说明子链的功能
     * @param string $chainDesc 8-16个字符，辅助描述子链的功能
     * @param string|null $chainPath 以“/”开头的子链对应的path路径
     * @param null $telephone SA类型的客服电话子链
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function add(string $chainName, string $chainDesc,string $chainPath = null,$telephone = null)
    {
        $params = [
            'chain_name' => $chainName,
            'chain_desc' => $chainDesc,
        ];
        if (!empty($chainPath)) {
            $params['chain_path'] = $chainPath;
        }
        if (!empty($telephone)) {
            $params['telephone'] = $telephone;
        }
        return $this->httpPost('rest/2.0/smartapp/subchain/add',$params);
    }

    /**
     * 删除已提交的子链。
     * @param string $subChainId 子链 Id
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function delete(string $subChainId)
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/delete', [
            'subchain_id' => $subChainId,
        ]);
    }

    /**
     * 更新子链
     * @link http://smartprogram.baidu.com/docs/develop/third/sitemap/#%E5%B0%8F%E7%A8%8B%E5%BA%8F%E5%8D%95%E5%8D%A1%E9%85%8D%E7%BD%AE
     * @param string $subChainId 子链 Id
     * @param string $chainName 4-10个字符，说明子链的功能
     * @param string $chainDesc 8-16个字符，辅助描述子链的功能
     * @param string|null $chainPath 以“/”开头的子链对应的path路径
     * @param null $telephone SA类型的客服电话子链
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function update(string $subChainId,string $chainName, string $chainDesc,string $chainPath = null,$telephone = null)
    {
        $params = [
            'subchain_id' => $subChainId,
            'chain_name' => $chainName,
            'chain_desc' => $chainDesc,
        ];
        if (!empty($chainPath)) {
            $params['chain_path'] = $chainPath;
        }
        if (!empty($telephone)) {
            $params['telephone'] = $telephone;
        }
        return $this->httpPost('rest/2.0/smartapp/subchain/update',$params);
    }


    /**
     * 获取所有的子链信息
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getAll()
    {
        return $this->httpGet('rest/2.0/smartapp/subchain/getall');
    }


    /**
     * 重排序子链
     * @param string $subChainRankList 子链 Id 字符串，顺序代表了排序位置,使用逗号分割
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function rank(string $subChainRankList)
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/rank', [
            'subchain_ranklist' => $subChainRankList
        ]);
    }

    /**
     * 停用子链 (针对审核通过的子链，可执行停用操作。停用后将暂停子链数据的分发展现。)
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function stop()
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/stop');
    }
    /**
     * 启用子链 (针对停用状态下的子链，可执行启用操作。启用后则可恢复子链的分发展现)
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function restart()
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/restart');
    }

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
        return $this->httpPost('rest/2.0/smartapp/package/upload', [
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
        return $this->httpPost('rest/2.0/smartapp/package/submitaudit', [
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
        return $this->httpPost('rest/2.0/smartapp/package/release', [
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
        return $this->httpPost('rest/2.0/smartapp/package/rollback', [
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
        return $this->httpPost('rest/2.0/smartapp/package/withdraw', [
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


    /**
     * @param string|null $path
     *
     * @return \EasyBaiDu\Kernel\Http\Response
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getQrCode(string $package_id, string $path = null, string $width = '200px')
    {
        return $this->requestRaw('rest/2.0/smartapp/app/qrcode', 'GET', [
            'query' => ['package_id' => $package_id],
        ]);
    }
    /** 以下API无用 **/
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
