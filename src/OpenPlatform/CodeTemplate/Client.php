<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\CodeTemplate;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author caikeal <caiyuezhang@gmail.com>
 */
class Client extends BaseClient
{

    /**
     * 获取代码模版库中的所有小程序代码模版.
     *
     * @return mixed
     */
    public function list($page = 1, $page_size = 10)
    {
        $params = [
            'page' => $page,
            'page_size' => $page_size,
        ];
        return $this->httpGet('rest/2.0/smartapp/template/gettemplatelist', $params);
    }

    /**
     * 删除指定小程序代码模版.
     *
     * @param $templateId
     *
     * @return mixed
     */
    public function delete($templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];

        return $this->httpPostJson('rest/2.0/smartapp/template/deltemplate', $params);
    }
    /**
     * 获取草稿箱内的所有临时代码草稿
     *
     * @return mixed
     */
    public function getDrafts($page = 1, $page_size = 10)
    {
        $params = [
            'page' => $page,
            'page_size' => $page_size,
        ];

        return $this->httpGet('rest/2.0/smartapp/template/gettemplatedraftlist', $params);
    }

    /**
     * 将草稿箱的草稿选为小程序代码模版.
     *
     * @param int $draftId 模板id
     * @param string $user_desc 自定义模板名称，30字以内
     *
     * @return mixed
     */
    public function createFromDraft(int $draftId, string $user_desc)
    {
        $params = [
            'draft_id' => $draftId,
            'user_desc' => $user_desc,
        ];

        return $this->httpPostJson('wxa/addtotemplate', $params);
    }

}
