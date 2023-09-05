<?php

namespace Kasir\Midtrans;

use Kasir\Midtrans\Concerns\CanMutateConfig;
use Kasir\Midtrans\Contracts\Arrayable;
use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Transaction implements Arrayable
{
    use CanMutateConfig;

    public function __construct(private array $config = [])
    {
    }

    public static function make(array $config = []): Transaction
    {
        return new self($config);
    }

    public function grossAmount(int $amount): Transaction
    {
        $this->config['transaction_details']['gross_amount'] = $amount;

        return new self($this->config);
    }

    public function getGrossAmount(): int
    {
        return $this->config['transaction_details']['gross_amount'];
    }

    public function orderId(string $orderId): Transaction
    {
        $this->config['transaction_details']['order_id'] = $orderId;

        return new self($this->config);
    }

    public function getOrderId(): string
    {
        return $this->config['transaction_details']['order_id'];
    }

    public function items(array $items): Transaction
    {
        $this->addConfig('item_details', $items);

        return new self($this->config);
    }

    public function paymentType(PaymentObject $object): Transaction
    {
        $this->mergeConfig($object->toArray());

        return new self($this->config);
    }

    public function toArray(): array
    {
        return $this->config;
    }
}
