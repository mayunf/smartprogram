<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\MiniProgram\AppCode;

use EasyBaiDu\Kernel\BaseClient;
use EasyBaiDu\Kernel\Http\StreamResponse;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     *
     * @param string $path
     * @param int|null $width
     * @param string $packageId
     * @return StreamResponse
     */
    public function qrCode(string $path, int $width = null, string $packageId = null)
    {
        $params = ['path' => $path];
        if (!empty($width)) {
            $params['width'] = $width;
        }
        if (!empty($packageId)) {
            $params['package_id'] = $packageId;
        }
        return $this->getStream('rest/2.0/smartapp/app/qrcode', $params);
    }


    /**
     * Get stream.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return \EasyBaiDu\Kernel\Http\StreamResponse
     */
    protected function getStream(string $endpoint, array $params)
    {
        $response = $this->requestRaw($endpoint, 'POST', ['json' => $params]);

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return StreamResponse::buildFromPsrResponse($response);
        }

        return $this->castResponseToType($response, $this->app['config']->get('response_type'));
    }
}
