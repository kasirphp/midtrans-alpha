<?php

namespace Kasir\Midtrans;

use Kasir\Midtrans\Concerns\InteractsWithPaymentAPI;
use Kasir\Midtrans\Concerns\InteractsWithSubscriptionAPI;
use Kasir\Midtrans\ValueObjects\Headers;

/**
 * @internal
 */
final class Client
{
    use InteractsWithPaymentAPI;
    use InteractsWithSubscriptionAPI;

    public function __construct(
        private readonly Headers $headers,
    ) {
        // ...
    }

    /*
     * Create idempotency key for the request.
     */
    public function idempotencyKey(string $key): Client
    {
        $headers = $this->headers->withIdempotencyKey($key);

        return new self($headers);
    }

    private function getAuthKey(): string
    {
        $key = $this->headers->toArray()['Authorization'];
        $needle = 'Basic ';
        $key = substr((string) $key, strpos((string) $key, $needle) + strlen($needle));
        $key = base64_decode($key);

        return substr($key, 0, strpos($key, ':'));
    }
}
