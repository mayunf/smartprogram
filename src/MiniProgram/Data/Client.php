<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\MiniProgram\Data;

use EasyBaiDu\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{


    // 用户趋势
    public function getAnalysisUserTrend(int $startIndex, string $gran, string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisusertrend', [
           'start_index' => $startIndex,
           'start_date' => $start,
           'end_date' => $end,
           'gran' => $gran,
        ]);
    }

    // 活跃用户
    public function getAnalysisActivityUser(int $startIndex, string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisactivityuser', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    // 活跃用户留存
    public function getAnalysisRetainedUser(int $startIndex, string $start, string $end, string $reportType, string $gran)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisretaineduser', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
            'gran' => $gran,
            'report_type' => $reportType,
        ]);
    }

    // 用户画像
    public function getAnalysisVisitAttribute(string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisvisitattribute', [
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    // 地域分布
    public function getAnalysisRegion(int $startIndex, string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisregion', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }
    // 终端分布
    public function getAnalysisTerminal(int $startIndex, string $start, string $end,string $terminalType)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisterminal', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
            'terminal_type' => $terminalType,
        ]);
    }

    // 页面分析
    public function getAnalysisVisitPage(int $startIndex, string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisvisitpage', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    // 终端分布
    public function getAnalysisVisitCharacter(int $startIndex, string $start, string $end,string $characterType)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysisvisitcharacter', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
            'character_type' => $characterType,
        ]);
    }


    // 来源分析
    public function getAnalysisSource(int $startIndex, string $start, string $end)
    {
        return $this->httpPost('rest/2.0/smartapp/data/getanalysissource', [
            'start_index' => $startIndex,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

}
