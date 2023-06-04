<?php

namespace Kasir\Midtrans\PaymentObjects\BankTransfer;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class MandiriBill extends PaymentObject
{
    public static function make(
        string $bill_info1,
        string $bill_info2,
        string $bill_info3 = null,
        string $bill_info4 = null,
        string $bill_info5 = null,
        string $bill_info6 = null,
        string $bill_info7 = null,
        string $bill_info8 = null,
        string $bill_key = null,
    ): MandiriBill {
        $options = array_filter(get_defined_vars(), 'strlen');

        return new self('echannel', 'echannel', $options);
    }
}
