<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class DanamonOnline extends PaymentObject
{
    /**
     * Create Danamon Online payment object.
     *
     *
     * @see https://docs.midtrans.com/reference/danamon-online-banking-dob
     */
    public static function make(): static
    {
        return new self('danamon_online');
    }
}
