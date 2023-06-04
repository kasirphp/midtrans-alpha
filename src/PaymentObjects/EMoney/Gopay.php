<?php

namespace Kasir\Midtrans\PaymentObjects\EMoney;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class Gopay extends PaymentObject
{
    public static function make(
        bool $enable_callback = false,
        string $callback_url = null,
        string $account_id = null,
        string $payment_option_token = null,
        bool $pre_auth = false,
        bool $recurring = false
    ): Gopay {
        $options = array_filter(get_defined_vars(), 'strlen');

        // TODO: Validate account id programmatically

        return new self('gopay', 'gopay', $options);
    }
}
