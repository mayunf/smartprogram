<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Data;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author dudashuang <dudashuang1222@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * TP平台数据获取(TP平台纬度）
     * @param int $scene 小程序来源ID (场景值)
     * @param string $metrics 指标以逗号分隔，全量指标如下：(https://smartprogram.baidu.com/docs/develop/third/datastatistics/)
     * @param string $start_date 起始时间戳,格式如 20190321
     * @param string $end_date 结束时间戳,格式如 20190325
     * @param int $start_index 偏移量,默认为0(分页操作从第几条开始展示)
     * @param int $max_result 页面大小,默认值20(分页操作查询条数)
     * @return array|\EasyBaiDu\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function getData(int $scene, string $metrics, string $start_date, string $end_date, int $start_index = 0, int $max_result = 20)
    {
        $params = [
            'scene' => $scene,
            'metrics' => $metrics,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_index' => $start_index,
            'max_result' => $max_result,
        ];
        return $this->httpGet('rest/2.0/smartapp/data/getdata', $params);
    }

/**
 * 查询创建任务状态.
 *
 * @param string $companyName
 * @param string $legalPersonaWechat
 * @param string $legalPersonaName
 *
 * @return array
 *
 * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
 */
public
function getRegistrationStatus(string $companyName, string $legalPersonaWechat, string $legalPersonaName)
{
    $params = [
        'name' => $companyName,
        'legal_persona_wechat' => $legalPersonaWechat,
        'legal_persona_name' => $legalPersonaName,
    ];

    return $this->httpPostJson('cgi-bin/component/fastregisterweapp', $params, ['action' => 'search']);
}
}
