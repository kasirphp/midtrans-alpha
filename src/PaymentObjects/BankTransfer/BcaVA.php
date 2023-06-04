<?php

namespace Kasir\Midtrans\PaymentObjects\BankTransfer;

use Kasir\Midtrans\PaymentObjects\PaymentObject;

final class BcaVA extends PaymentObject
{
    public static function make(
        string $va_number = null,
        string $sub_company_code = null,
        string $inquiry_text_en = null,
        string $inquiry_text_id = null,
        string $payment_text_en = null,
        string $payment_text_id = null
    ): BcaVA {
        $options = ['va_number' => $va_number];
        $options['bca'] = ['sub_company_code' => $sub_company_code];
        $options['bank'] = 'bca';

        if ($inquiry_text_en || $inquiry_text_id) {
            $options['free_text']['inquiry'] = [
                'en' => $inquiry_text_en,
                'id' => $inquiry_text_id,
            ];
        }

        if ($payment_text_en || $payment_text_id) {
            $options['free_text']['payment'] = [
                'en' => $payment_text_en,
                'id' => $payment_text_id,
            ];
        }

        return new self('bank_transfer', 'bank_transfer', $options);
    }
}
