<?php

namespace Kasir\Midtrans\PaymentObjects\CStore;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Alfamart extends PaymentObject
{
    public static function make(
        string $alfamart_free_text_1 = null,
        string $alfamart_free_text_2 = null,
        string $alfamart_free_text_3 = null
    ): Alfamart {
        $options = array_filter(get_defined_vars(), 'strlen');
        $options['store'] = 'alfamart';

        return new self('cstore', 'cstore', $options);
    }
}
