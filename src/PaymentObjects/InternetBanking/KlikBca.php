<?php

namespace Kasir\Midtrans\PaymentObjects\InternetBanking;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class KlikBca extends PaymentObject
{
    public static function make(string $description, string $user_id): static
    {
        $options = array_filter(get_defined_vars(), 'strlen');

        return new self('bca_klikbca', 'bca_klikbca', $options);
    }
}
