<?php

namespace Kasir\Midtrans;

use Kasir\Midtrans\Exception\AuthenticationException;
use Kasir\Midtrans\Exception\InvalidArgumentException;
use Kasir\Midtrans\Util\ApiVersion;
use Kasir\Midtrans\Util\RequestOptions;
use Kasir\Midtrans\Util\Util;

class BaseClient implements ClientInterface
{
    const DEFAULT_API_BASE = 'https://api.midtrans.com';

    const DEFAULT_SANDBOX_API_BASE = 'https://api.sandbox.midtrans.com';

    const DEFAULT_CONFIG = [
        'api_key' => null,
        'midtrans_version' => ApiVersion::CURRENT,
        'api_base' => self::DEFAULT_API_BASE,
    ];

    private array $config;

    private RequestOptions $defaultOpts;


    public function __construct(array|string $config = [])
    {
        if (is_string($config)) {
            $config = ['api_key' => $config];
        }

        $config = array_merge(self::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->config = $config;

        $this->defaultOpts = RequestOptions::parse([
            'midtrans_version' => $this->config['midtrans_version'],
        ]);
    }

    public function getApiKey(): string
    {
        return $this->config['api_key'];
    }

    public function getApiBase(): string
    {
        return $this->config['api_base'];
    }

    public function request($method, $path, $params, $opts)
    {
        $opts = $this->defaultOpts->merge($opts, true);
        $baseUrl = $opts->apiBase ?: $this->getApiBase();
        $requester = new ApiRequester($this->apiKeyForRequest($opts), $baseUrl); // TODO: Create ApiRequester class
        list($response, $opts->apiKey) = $requester->request($method, $path, $params, $opts->headers);
        $opts->discardNonPersistentHeaders();

        // Do we need this?
        $obj = Util::convertToMidtransObject($response->json, $opts); // TODO: Create Util class and StripeObject class

        $obj->setLastResponse($response);

        return $obj;
    }

    private function apiKeyForRequest($opts): string
    {
        $apiKey = $opts->apiKey ?: $this->getApiKey();

        if (null === $apiKey) {
            $message = 'No API key provided.';

            throw new AuthenticationException($message);
        }

        return $apiKey;
    }

    private function validateConfig($config): void
    {
        // api_key
        if (null !== $config['api_key'] && !\is_string($config['api_key'])) {
            throw new InvalidArgumentException('api_key must be null or a string');
        }

        if (empty($config['api_key'])) {
            throw new InvalidArgumentException('api_key cannot be an empty string');
        }

        if (preg_match('/\s/', $config['api_key'])) {
            throw new InvalidArgumentException('api_key cannot contain whitespace');
        }

        // midtrans_version
        if (null !== $config['midtrans_version'] && !\is_string($config['midtrans_version'])) {
            throw new InvalidArgumentException('midtrans_version must be null or a string');
        }

        // api_base
        if (!\is_string($config['api_base'])) {
            throw new InvalidArgumentException('api_base must be a string');
        }

        // absence of extra keys
        $extraConfigKeys = \array_diff(\array_keys($config), \array_keys(self::DEFAULT_CONFIG));
        if (!empty($extraConfigKeys)) {
            // Wrap in single quote to more easily catch trailing spaces errors
            $invalidKeys = "'".\implode("', '", $extraConfigKeys)."'";

            throw new InvalidArgumentException('Found unknown key(s) in configuration array: '.$invalidKeys);
        }
    }
}