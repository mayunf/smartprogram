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

use EasyBaiDu\Kernel\Contracts\AccessTokenInterface;
use EasyBaiDu\Kernel\Exceptions\HttpException;
use EasyBaiDu\Kernel\Exceptions\InvalidArgumentException;
use EasyBaiDu\Kernel\Exceptions\RuntimeException;
use EasyBaiDu\Kernel\Traits\HasHttpRequests;
use EasyBaiDu\Kernel\Traits\InteractsWithCache;
use Pimple\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
abstract class AccessToken implements AccessTokenInterface
{
    use HasHttpRequests, InteractsWithCache;

    /**
     * @var \Pimple\Container
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $token;

    /**
     * @var int
     */
    protected $safeSeconds = 500;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'EasyBaiDu.kernel.access_token.';

    /**
     * AccessToken constructor.
     *
     * @param \Pimple\Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function getRefreshedToken(): array
    {
        return $this->getToken(true);
    }

    /**
     * @param bool $refresh
     *
     * @return array
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }
        $token = $this->requestToken($this->getCredentials(), true);
        $this->setToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);
        return $token;
    }

    /**
     * @param string $token
     * @param int    $lifetime
     *
     * @return \EasyBaiDu\Kernel\Contracts\AccessTokenInterface
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function setToken(string $token, int $lifetime = 7200): AccessTokenInterface
    {
        $this->getCache()->set($this->getCacheKey(), [
            $this->tokenKey => $token,
            'expires_in' => $lifetime,
        ], $lifetime - $this->safeSeconds);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache access token.');
        }

        return $this;
    }

    /**
     * @return \EasyBaiDu\Kernel\Contracts\AccessTokenInterface
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function refresh(): AccessTokenInterface
    {
        $this->getToken(true);

        return $this;
    }

    /**
     * @param array $credentials
     * @param bool  $toArray
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyBaiDu\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);
        $formatted = $this->castResponseToType($response, $this->app['config']->get('response_type'));

        if (empty($result['data']) && empty($result['access_token'])) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response, $formatted);
        }
        if (isset($result['data'])) {
            return $toArray ? $result['data'] : $formatted;
        }
        return $toArray ? $result : $formatted;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return \Psr\Http\Message\RequestInterface
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge($this->getQuery(), $query));

        return $request->withUri($request->getUri()->withQuery($query));
    }

    /**
     * Send http request.
     *
     * @param array $credentials
     *
     * @return ResponseInterface
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     */
    protected function sendRequest(array $credentials): ResponseInterface
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : 'json' => $credentials,
        ];

        return $this->setHttpClient($this->app['http_client'])->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @return array
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyBaiDu\Kernel\Exceptions\RuntimeException
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->getToken()[$this->tokenKey]];
    }

    /**
     * @return string
     *
     * @throws \EasyBaiDu\Kernel\Exceptions\InvalidArgumentException
     */
    public function getEndpoint(): string
    {
        if (empty($this->endpointToGetToken)) {
            throw new InvalidArgumentException('No endpoint for access token request.');
        }

        return $this->endpointToGetToken;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}