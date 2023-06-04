<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class UobEzpay extends PaymentObject
{
    public static function make(): UobEzpay
    {
        return new self('uob_ezpay');
    }
}
