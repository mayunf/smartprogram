<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Auth;

use EasyBaiDu\Kernel\Exceptions\RuntimeException;
use EasyBaiDu\Kernel\Traits\InteractsWithCache;
use EasyBaiDu\OpenPlatform\Application;

/**
 * Class VerifyTicket.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class VerifyTicket
{
    use InteractsWithCache;

    /**
     * @var \EasyBaiDu\OpenPlatform\Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param \EasyBaiDu\OpenPlatform\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Put the credential `component_verify_ticket` in cache.
     *
     * @param string $ticket
     *
     * @return $this
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function setTicket(string $ticket)
    {
        $this->getCache()->set($this->getCacheKey(), $ticket, 3600);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache verify ticket.');
        }

        return $this;
    }

    /**
     * Get the credential `component_verify_ticket` from cache.
     *
     * @return string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getTicket(): string
    {
        if ($cached = $this->getCache()->get($this->getCacheKey())) {
            return $cached;
        }

        throw new RuntimeException('Credential "component_verify_ticket" does not exist in cache.');
    }

    /**
     * Get cache key.
     *
     * @return string
     */
    protected function getCacheKey(): string
    {
        return 'EasyBaiDu.open_platform.verify_ticket.'.$this->app['config']['app_id'];
    }
}
