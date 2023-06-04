<?php

namespace Kasir\Midtrans\PaymentObjects\CardlessCredit;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Kredivo extends PaymentObject
{
    public static function make(): Kredivo
    {
        return new self('kredivo');
    }
}
