<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform\Server;

use EasyBaiDu\Kernel\ServerGuard;
use EasyBaiDu\OpenPlatform\Server\Handlers\Authorized;
use EasyBaiDu\OpenPlatform\Server\Handlers\Unauthorized;
use EasyBaiDu\OpenPlatform\Server\Handlers\UpdateAuthorized;
use EasyBaiDu\OpenPlatform\Server\Handlers\VerifyTicketRefreshed;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Guard.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Guard extends ServerGuard
{
    const EVENT_AUTHORIZED = 'authorized';
    const EVENT_UNAUTHORIZED = 'unauthorized';
    const EVENT_UPDATE_AUTHORIZED = 'updateauthorized';
    const EVENT_COMPONENT_VERIFY_TICKET = 'ticket';

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resolve(): Response
    {
        $this->registerHandlers();

        $message = $this->getMessage();

        if (isset($message['MsgType'])) {
            $this->dispatch($message['MsgType'], $message);
        }

        return new Response(static::SUCCESS_EMPTY_RESPONSE);
    }

    /**
     * Register event handlers.
     */
    protected function registerHandlers()
    {
        $this->on(self::EVENT_AUTHORIZED, Authorized::class);
        $this->on(self::EVENT_UNAUTHORIZED, Unauthorized::class);
        $this->on(self::EVENT_UPDATE_AUTHORIZED, UpdateAuthorized::class);
        $this->on(self::EVENT_COMPONENT_VERIFY_TICKET, VerifyTicketRefreshed::class);
    }
}
