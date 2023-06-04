<?php

namespace Kasir\Midtrans\PaymentObjects;

final class CreditCard extends PaymentObject
{
    public static function make(string $token_id, bool $authorize = false): CreditCard
    {
        $options = [
            'token_id' => $token_id,
        ];

        if ($authorize) {
            $options['type'] = 'authorize';
        }

        return new self('credit_card', 'credit_card', $options);
    }
}
