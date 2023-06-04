<?php

namespace Kasir\Midtrans\Responses\Concerns;

/**
 * @internal
 */
trait SuccessfulResponse
{
    public function transactionId(): ?string
    {
        return $this->json('transaction_id');
    }

    public function orderId(): ?string
    {
        return $this->json('order_id');
    }

    public function grossAmount(): ?int
    {
        return (int) $this->json('gross_amount');
    }

    public function transactionStatus(): ?string
    {
        return $this->json('transaction_status');
    }

    public function paymentType(): ?string
    {
        return $this->json('payment_type');
    }

    public function actions(): array|string|null
    {
        return $this->json('actions');
    }

    public function redirectUrl(): array|string|null
    {
        return $this->json('redirect_url');
    }

    public function qrString(): ?string
    {
        return $this->json('qr_string');
    }
}
