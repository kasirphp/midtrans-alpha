<?php

namespace Kasir\Midtrans\Util;

use Kasir\Midtrans\Exception\InvalidArgumentException;

class RequestOptions
{
    public static array $HEADERS_TO_PERSIST = [
        'Midtrans-Version',
    ];

    public array $headers;

    public ?string $apiKey;

    public ?string $apiBase;

    public function __construct($key = null, $headers = [], $base = null)
    {
        $this->apiKey = $key;
        $this->headers = $headers;
        $this->apiBase = $base;
    }

    public function __debugInfo(): ?array
    {
        return [
            'apiKey' => $this->redactedApiKey(),
            'headers' => $this->headers,
            'apiBase' => $this->apiBase,
        ];
    }

    public function merge($options, $strict = false): RequestOptions
    {
        $other_options = self::parse($options, $strict);
        if (null === $other_options->apiKey) {
            $other_options->apiKey = $this->apiKey;
        }
        $other_options->headers = array_merge($this->headers, $other_options->headers);
        if (null === $other_options->apiBase) {
            $other_options->apiBase = $this->apiBase;
        }

        return $other_options;
    }

    public function discardNonPersistentHeaders(): void
    {
        foreach ($this->headers as $key => $value) {
            if (!\in_array($key, self::$HEADERS_TO_PERSIST, true)) {
                unset($this->headers[$key]);
            }
        }
    }

    public static function parse($options, $strict = false): RequestOptions
    {
        if ($options instanceof self) {
            return clone $options;
        }

        if (null === $options) {
            return new RequestOptions(null, [], null);
        }

        if (is_string($options)) {
            if ($strict) {
                $message = 'Do not pass a string for request options. If you want to set the '
                    . 'API key, pass an array like ["api_key" => <apiKey>] instead.';

                throw new InvalidArgumentException($message);
            }

            return new RequestOptions($options, [], null);
        }

        if (is_array($options)) {
            $headers = [];
            $key = null;
            $base = null;

            if (array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
                unset($options['api_key']);
            }
            if (array_key_exists('idempotency_key', $options)) {
                $headers['Idempotency-Key'] = $options['idempotency_key'];
                unset($options['idempotency_key']);
            }
            if (array_key_exists('api_base', $options)) {
                $base = $options['api_base'];
                unset($options['api_base']);
            }

            if ($strict && !empty($options)) {
                $message = 'Got unexpected keys in options array: ' . implode(', ', array_keys($options));

                throw new InvalidArgumentException($message);
            }

            return new RequestOptions($key, $headers, $base);
        }

        $message = 'The second argument to Midtrans API method calls is an '
            . 'optional per-request apiKey, which must be a string, or '
            . 'per-request options, which must be an array.';

        throw new InvalidArgumentException($message);
    }

    private function redactedApiKey(): string
    {
        if (null === $this->apiKey) {
            return '';
        }

        $pieces = \explode('_', $this->apiKey, 3);
        $last = \array_pop($pieces);
        $redactedLast = \strlen($last) > 4
            ? (\str_repeat('*', \strlen($last) - 4).\substr($last, -4))
            : $last;
        $pieces[] = $redactedLast;

        return \implode('_', $pieces);
    }
}