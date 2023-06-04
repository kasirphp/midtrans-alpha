<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class CimbClicks extends PaymentObject
{
    public static function make(string $description = null): CimbClicks
    {
        $options = array_filter(get_defined_vars(), 'strlen');

        return new self('cimb_clicks', 'cimb_clicks', $options);
    }
}
