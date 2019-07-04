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

use ArrayAccess;

/**
 * Interface Arrayable.
 *
 * @author overtrue <i@overtrue.me>
 */
interface Arrayable extends ArrayAccess
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}
