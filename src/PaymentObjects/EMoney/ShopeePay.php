<?php

namespace Kasir\Midtrans\PaymentObjects\EMoney;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class ShopeePay extends PaymentObject
{
    public static function make(string $callback_url = null): ShopeePay
    {
        $options = get_defined_vars();

        return new self('shopeepay', 'shopeepay', $options);
    }
}
