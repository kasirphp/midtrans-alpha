<?php

namespace Kasir\Midtrans\ValueObjects;

/**
 * @internal
 */
final class BaseUrl
{
    private const protocol = 'https://';

    private const base_url = 'midtrans.com';

    public static function with(string $path, bool $production = false): string
    {
        $url = self::protocol.'api.'.($production ? '' : 'sandbox.').self::base_url;

        $path = str_starts_with($path, '/') ? $path : '/'.$path;

        return $url.$path;
    }
}
