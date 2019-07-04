<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 * 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\Kernel\Messages;

/**
 * Class Location.
 */
class Location extends Message
{
    /**
     * Messages type.
     *
     * @var string
     */
    protected $type = 'location';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
        'latitude',
        'longitude',
        'scale',
        'label',
        'precision',
    ];
}
