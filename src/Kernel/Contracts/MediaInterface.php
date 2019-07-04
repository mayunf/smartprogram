<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\Kernel\Contracts;

/**
 * Interface MediaInterface.
 *
 * @author overtrue <i@overtrue.me>
 */
interface MediaInterface extends MessageInterface
{
    /**
     * @return string
     */
    public function getMediaId(): string;
}
