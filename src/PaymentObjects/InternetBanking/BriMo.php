<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class BriMo extends PaymentObject
{
    public static function make(string $description, string $misc_fee = null): BriMo
    {
        $options = array_filter(get_defined_vars(), 'strlen');

        return new self('bca_klikpay', 'bca_klikpay', $options);
    }
}
