<?php

namespace Kasir\Midtrans\PaymentObjects\EMoney;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Qris extends PaymentObject
{
    public static function make(string $acquirer = 'gopay'): PaymentObject
    {
        return new self('qris', 'qris', array_filter(get_defined_vars(), 'strlen'));
    }
}
