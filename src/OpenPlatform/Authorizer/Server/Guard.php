<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\Server;

use EasyBaiDu\Kernel\ServerGuard;

/**
 * Class Guard.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Guard extends ServerGuard
{
    /**
     * Get token from OpenPlatform encryptor.
     *
     * @return string
     */
    protected function getToken()
    {
        return $this->app['encryptor']->getToken();
    }
}
