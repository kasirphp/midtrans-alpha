<?php

namespace Kasir\Midtrans\PaymentObjects;

use Kasir\Midtrans\Contracts\Arrayable;

/**
 * @internal
 */
abstract class PaymentObject implements Arrayable
{
    public function __construct(
        protected readonly string $type,
        protected readonly ?string $option_key = null,
        protected readonly ?array $options = null,
    ) {
        // ...
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $payload = [];
        $payload['payment_type'] = $this->type;

        if (! is_null($this->option_key)) {
            $payload[$this->option_key] = $this->options;
        }

        return $payload;
    }
}
