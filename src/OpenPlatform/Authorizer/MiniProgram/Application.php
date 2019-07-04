<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Authorizer\MiniProgram;

use EasyBaiDu\MiniProgram\Application as MiniProgram;
use EasyBaiDu\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Account\Client $account
 * @property \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Code\Client    $code
 * @property \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Domain\Client  $domain
 * @property \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Setting\Client $setting
 * @property \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Tester\Client  $tester
 */
class Application extends MiniProgram
{
    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($config, $prepends);

        $providers = [
            AggregateServiceProvider::class,
            Code\ServiceProvider::class,
            Domain\ServiceProvider::class,
            Account\ServiceProvider::class,
            Setting\ServiceProvider::class,
            Tester\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
