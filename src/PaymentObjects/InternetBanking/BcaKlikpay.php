<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class BcaKlikpay extends PaymentObject
{
    public static function make(string $description, string $misc_fee = null): BcaKlikpay
    {
        $options = array_filter(get_defined_vars(), 'strlen');

        return new self('bca_klikpay', 'bca_klikpay', $options);
    }
}
