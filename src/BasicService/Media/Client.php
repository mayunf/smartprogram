<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\BasicService\Media;

use EasyBaiDu\Kernel\BaseClient;
use EasyBaiDu\Kernel\Exceptions\InvalidArgumentException;
use EasyBaiDu\Kernel\Http\StreamResponse;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends BaseClient
{
    /**
     * @var string
     */
    protected $baseUri = 'https://openapi.baidu.com/';

    /**
     * Allow media type.
     *
     * @var array
     */
    protected $allowTypes = ['bmp','jpeg','jpg','png'];

    /**
     * Upload image.
     *
     * @param $path
     * @param int $type
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     */
    public function uploadImage($path,$type=1)
    {
        return $this->upload($path,$type);
    }



    /**
     * Upload temporary material.
     *
     * @param int $type
     * @param string $multipartFile
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     */
    public function upload(string $multipartFile, int $type=1)
    {
        if (!file_exists($multipartFile) || !is_readable($multipartFile)) {
            throw new InvalidArgumentException(sprintf("File does not exist, or the file is unreadable: '%s'", $multipartFile));
        }

//        if (!in_array($type, $this->allowTypes, true)) {
//            throw new InvalidArgumentException(sprintf("Unsupported media type: '%s'", $type));
//        }

        return $this->httpUpload('file/2.0/smartapp/upload/image', ['multipartFile' => $multipartFile], ['type' => $type]);
    }



}
