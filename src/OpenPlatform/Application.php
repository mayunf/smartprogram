<?php

/*
 * This file is part of the mayunfeng/smartprogram.
 *
 *
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyBaiDu\OpenPlatform;

use EasyBaiDu\Kernel\Exceptions\Exception;
use EasyBaiDu\Kernel\ServiceContainer;
use EasyBaiDu\MiniProgram\Encryptor;
use EasyBaiDu\OpenPlatform\Authorizer\Auth\AccessToken;
use EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Application as MiniProgram;
use EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Auth\Client;
use EasyBaiDu\OpenPlatform\Authorizer\Server\Guard;

/**
 * Class Application.
 *
 * @property \EasyBaiDu\OpenPlatform\Server\Guard        $server
 * @property \EasyBaiDu\OpenPlatform\Auth\AccessToken    $access_token
 * @property \EasyBaiDu\OpenPlatform\CodeTemplate\Client $code_template
 * @property \EasyBaiDu\OpenPlatform\Data\Client $data
 *
 * @method mixed handleAuthorize(string $authCode = null)
 * @method mixed getAuthorizer(string $appId)
 * @method mixed getAuthorizerOption(string $appId, string $name)
 * @method mixed setAuthorizerOption(string $appId, string $name, string $value)
 * @method mixed getAuthorizers(int $offset = 0, int $count = 500)
 * @method mixed createPreAuthorizationCode()
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        CodeTemplate\ServiceProvider::class,
        Data\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'http' => [
            'timeout' => 5.0,
            'base_uri' => 'https://openapi.baidu.com/',
        ],
    ];


    /**
     * Creates the miniProgram application.
     *
     * @param string                                                    $appId
     * @param string|null                                               $refreshToken
     * @param \EasyBaiDu\OpenPlatform\Authorizer\Auth\AccessToken|null $accessToken
     *
     * @return \EasyBaiDu\OpenPlatform\Authorizer\MiniProgram\Application
     */
    public function miniProgram(string $appId, string $refreshToken = null, AccessToken $accessToken = null): MiniProgram
    {
        if (!$this->access_token->getCache()->has($this->access_token->getCachePrefix().$appId)) {
            $res = $this->retrieveAuthcode($appId);
            if (!isset($res['data'])) {
                throw new Exception($res['msg']);
            }
            $refreshToken = $res['data']['authorization_code'];
        }
        return new MiniProgram($this->getAuthorizerConfig($appId, $refreshToken), $this->getReplaceServices($accessToken) + [
            'encryptor' => function () {
                return new Encryptor($this['config']['app_id'], $this['config']['token'], $this['config']['aes_key']);
            },

            'auth' => function ($app) {
                return new Client($app, $this);
            },
        ]);
    }

    /**
     * Return the pre-authorization login page url.
     *
     * @param string            $callbackUrl
     * @param string|array|null $optional
     *
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        // 兼容旧版 API 设计
        if (\is_string($optional)) {
            $optional = [
                'pre_auth_code' => $optional,
            ];
        } else {
            $authCode = $this->createPreAuthorizationCode();
            $optional['pre_auth_code'] = $authCode['data']['pre_auth_code'];
        }

        $queries = \array_merge($optional, [
            'client_id' => $this['config']['app_id'],
            'redirect_uri' => $callbackUrl,
        ]);

        return 'https://smartprogram.baidu.com/mappconsole/tp/authorization?'.http_build_query($queries);
    }


    /**
     * @param string      $appId
     * @param string|null $refreshToken
     *
     * @return array
     */
    protected function getAuthorizerConfig(string $appId, string $refreshToken = null): array
    {
        return $this['config']->merge([
//            'component_app_id' => $this['config']['app_id'],
//            'app_id' => $appId,
            'refresh_token' => $refreshToken,
            'mina_app_id' => $appId
        ])->toArray();
    }

    /**
     * @param \EasyBaiDu\OpenPlatform\Authorizer\Auth\AccessToken|null $accessToken
     *
     * @return array
     */
    protected function getReplaceServices(AccessToken $accessToken = null): array
    {
        $services = [
            'access_token' => $accessToken ?: function ($app) {
                return new AccessToken($app, $this);
            },

            'server' => function ($app) {
                return new Guard($app);
            },
        ];

        foreach (['cache', 'http_client', 'log', 'logger', 'request'] as $reuse) {
            if (isset($this[$reuse])) {
                $services[$reuse] = $this[$reuse];
            }
        }

        return $services;
    }

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}
