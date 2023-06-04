<?php

namespace Kasir\Midtrans\ValueObjects;

use Kasir\Midtrans\Contracts\Arrayable;

final class Headers implements Arrayable
{
    public function __construct(private readonly array $headers)
    {
        // ...
    }

    public static function withAuthorization(string $key): Headers
    {
        return new self([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($key.':'),
        ]);
    }

    public function withIdempotencyKey(string $key): Headers
    {
        $headers = $this->headers;

        $headers['Idempotency-Key'] = $key;

        return new self($headers);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
