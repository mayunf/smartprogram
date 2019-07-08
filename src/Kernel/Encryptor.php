<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\Kernel;

use EasyBaiDu\Kernel\Exceptions\RuntimeException;
use EasyBaiDu\Kernel\Support\AES;
use EasyBaiDu\Kernel\Support\XML;
use Throwable;
use function EasyBaiDu\Kernel\Support\str_random;

/**
 * Class Encryptor.
 *
 * @author overtrue <i@overtrue.me>
 */
class Encryptor
{
    const ERROR_INVALID_SIGNATURE = -40001; // Signature verification failed
    const ERROR_PARSE_XML = -40002; // Parse XML failed
    const ERROR_CALC_SIGNATURE = -40003; // Calculating the signature failed
    const ERROR_INVALID_AES_KEY = -40004; // Invalid AESKey
    const ERROR_INVALID_APP_ID = -40005; // Check AppID failed
    const ERROR_ENCRYPT_AES = -40006; // AES EncryptionInterface failed
    const ERROR_DECRYPT_AES = -40007; // AES decryption failed
    const ERROR_INVALID_XML = -40008; // Invalid XML
    const ERROR_BASE64_ENCODE = -40009; // Base64 encoding failed
    const ERROR_BASE64_DECODE = -40010; // Base64 decoding failed
    const ERROR_XML_BUILD = -40011; // XML build failed
    const ILLEGAL_BUFFER = -41003; // Illegal buffer

    /**
     * App id.
     *
     * @var string
     */
    protected $appId;

    /**
     * App token.
     *
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $aesKey;

    /**
     * Block size.
     *
     * @var int
     */
    protected $blockSize = 32;

    /**
     * Constructor.
     *
     * @param string      $appId
     * @param string|null $token
     * @param string|null $aesKey
     */
    public function __construct(string $appId, string $token = null, string $aesKey = null)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->aesKey = base64_decode($aesKey.'=', true);
    }

    /**
     * Get the app token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Encrypt the message and return XML.
     *
     * @param string $xml
     * @param string $nonce
     * @param int    $timestamp
     *
     * @return string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function encrypt($xml, $nonce = null, $timestamp = null): string
    {
        try {
            // 获得16位随机字符串，填充到明文之前
            $random = $this->getRandomStr();;
            $text = $random . pack("N", strlen($text)) . $text . $this->appId;
            $iv = substr($this->aesKey, 0, 16);
            // 对明文进行补位填充
            $text = $this->encode($text);
            // 加密
            $encrypted = openssl_encrypt($text, 'aes-256-cbc', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
            // 使用BASE64对加密后的字符串进行编码
            return base64_encode($encrypted);
        } catch (Exception $e) {
            throw new Exception("加密失败");
        }


        try {
            $xml = $this->pkcs7Pad(str_random(16).pack('N', strlen($xml)).$xml.$this->appId, $this->blockSize);

            $encrypted = base64_encode(AES::encrypt(
                $xml,
                $this->aesKey,
                substr($this->aesKey, 0, 16),
                OPENSSL_NO_PADDING
            ));
            // @codeCoverageIgnoreStart
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage(), self::ERROR_ENCRYPT_AES);
        }
        // @codeCoverageIgnoreEnd

        !is_null($nonce) || $nonce = substr($this->appId, 0, 10);
        !is_null($timestamp) || $timestamp = time();

        $response = [
            'Encrypt' => $encrypted,
            'MsgSignature' => $this->signature($this->token, $timestamp, $nonce, $encrypted),
            'TimeStamp' => $timestamp,
            'Nonce' => $nonce,
        ];

        //生成响应xml
        return XML::build($response);
    }

    /**
     * Decrypt message.
     *
     * @param string $content
     * @param string $msgSignature
     * @param string $nonce
     * @param string $timestamp
     *
     * @return string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function decrypt($content, $msgSignature, $nonce, $timestamp): string
    {
        try {
            // 使用BASE64对需要解密的字符串进行解码
            $ciphertextDec = base64_decode($content);
            $iv = substr($this->aesKey, 0, 16);
            // 解密
            $decrypted = openssl_decrypt($ciphertextDec, 'aes-256-cbc', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
        } catch (\Exception $e) {
            throw new \Exception('AesEncryptUtil AES解密串非法，小于16位;');
        }
        try {
            // 去除补位字符
            $result = $this->decode($decrypted);
            // 去除16位随机字符串,网络字节序和clientId
            if (strlen($result) < 16) {
                throw new \Exception('AesEncryptUtil AES解密串非法，小于16位;');
            }
            $content = substr($result, 16, strlen($result));
            $lenList = unpack("N", substr($content, 0, 4));
            $xmlLen = $lenList[1];
            $xmlContent = substr($content, 4, $xmlLen);
            $fromClientId = substr($content, $xmlLen + 4);
        } catch (\Exception $e) {
            throw new \Exception('AesEncryptUtil AES解密串非法，小于16位;');
        }
//        dd($fromClientId);
//        if ($fromClientId != $this->appId) {
//            throw new \Exception('AesEncryptUtil AES解密串非法，小于16位;');
//        }

        return $xmlContent;


//        $signature = $this->signature($this->token, $timestamp, $nonce, $content);

//        if ($signature !== $msgSignature) {
//            throw new RuntimeException('Invalid Signature.', self::ERROR_INVALID_SIGNATURE);
//        }

/*        $decrypted = AES::decrypt(
            base64_decode($content, true),
            $this->aesKey,
            substr($this->aesKey, 0, 16),
            OPENSSL_NO_PADDING
        );
        $result = $this->pkcs7Unpad($decrypted);
        $content = substr($result, 16, strlen($result));
        $contentLen = unpack('N', substr($content, 0, 4))[1];

        if (trim(substr($content, $contentLen + 4)) !== $this->appId) {
            throw new RuntimeException('Invalid appId.', self::ERROR_INVALID_APP_ID);
        }

        return substr($content, 4, $contentLen);*/
    }

    /**
     * PKCS#7 pad.
     *
     * @param string $text
     * @param int    $blockSize
     *
     * @return string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function pkcs7Pad(string $text, int $blockSize): string
    {
        if ($blockSize > 256) {
            throw new RuntimeException('$blockSize may not be more than 256');
        }
        $padding = $blockSize - (strlen($text) % $blockSize);
        $pattern = chr($padding);

        return $text.str_repeat($pattern, $padding);
    }


    /**
     * 对解密后的明文进行补位删除
     * @param $text
     * @return bool|string
     */
    public function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > $this->blockSize) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

    /**
     * 对需要加密的明文进行填充补位
     * @param $text
     * @return string
     */
    private function encode($text)
    {
        $textLength = strlen($text);
        //计算需要填充的位数
        $amountToPad = self::$blockSize - ($textLength % self::$blockSize);
        if ($amountToPad == 0) {
            $amountToPad = self::$blockSize;
        }
        //获得补位所用的字符
        $padChr = chr($amountToPad);
        $tmp = "";
        for ($index = 0; $index < $amountToPad; $index++) {
            $tmp .= $padChr;
        }
        return $text . $tmp;
    }

    /**
     * 随机生成16位字符串
     * @return string
     */
    private function getRandomStr()
    {
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        $str = "";
        for ($i = 0; $i < 16; $i++) {
            $str .= $strPol[mt_rand(0, $max)];
        }
        return $str;
    }
}
