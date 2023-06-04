<?php

namespace Kasir\Midtrans\PaymentObjects\BankTransfer;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class PermataVA extends PaymentObject
{
    public static function make(string $va_number = null, string $recipient_name = null): PermataVA
    {
        $options = ['va_number' => $va_number];
        $options['bank'] = 'permata';

        if ($recipient_name) {
            $options['permata']['recipient_name'] = $recipient_name;
        }

        return new self('bank_transfer', 'bank_transfer', $options);
    }
}
