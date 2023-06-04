<?php

namespace Kasir\Midtrans\PaymentObjects\BankTransfer;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class BriVA extends PaymentObject
{
    public static function make(string $va_number = null): BriVA
    {
        $options = array_filter(get_defined_vars(), 'strlen');
        $options['bank'] = 'bri';

        return new self('bank_transfer', 'bank_transfer', $options);
    }
}
