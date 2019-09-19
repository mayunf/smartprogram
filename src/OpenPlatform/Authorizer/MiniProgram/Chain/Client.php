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
    public function stop(string $subChainId)
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/stop', [
            'subchain_id' => $subChainId,
        ]);
    }
    /**
     * 启用子链 (针对停用状态下的子链，可执行启用操作。启用后则可恢复子链的分发展现)
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function restart(string $subChainId)
    {
        return $this->httpPost('rest/2.0/smartapp/subchain/restart', [
            'subchain_id' => $subChainId,
        ]);
    }

}
