<?php

namespace Kasir\Midtrans;

use Kasir\Midtrans\ValueObjects\Headers;

final class Midtrans
{
    public static function client(string $key): Client
    {
        $headers = Headers::withAuthorization($key);

        return new Client($headers);
    }
}
