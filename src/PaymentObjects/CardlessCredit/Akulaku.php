<?php

namespace Kasir\Midtrans\PaymentObjects\CardlessCredit;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Akulaku extends PaymentObject
{
    public static function make(): Akulaku
    {
        return new self('akulaku');
    }
}
