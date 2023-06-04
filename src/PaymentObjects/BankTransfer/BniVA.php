<?php

namespace Kasir\Midtrans\PaymentObjects\BankTransfer;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class BniVA extends PaymentObject
{
    public static function make(string $va_number = null): BniVA
    {
        $options = array_filter(get_defined_vars(), 'strlen');
        $options['bank'] = 'bni';

        return new self('bank_transfer', 'bank_transfer', $options);
    }
}
