<?php

namespace Kasir\Midtrans\PaymentObjects\CStore;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Indomaret extends PaymentObject
{
    public static function make(string $message): Indomaret
    {
        $options = array_filter(get_defined_vars(), 'strlen');
        $options['store'] = 'indomaret';

        return new self('cstore', 'cstore', $options);
    }
}
