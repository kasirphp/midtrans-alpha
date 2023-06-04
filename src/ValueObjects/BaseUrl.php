<?php

namespace Kasir\Midtrans\ValueObjects;

/**
 * @internal
 */
final class BaseUrl
{
    private const production_url = 'https://api.midtrans.com';

    private const sandbox_url = 'https://api.sandbox.midtrans.com';

    public static function with(string $path, bool $snap = false, bool $production = false, string $version = 'v2'): string
    {
        $url = $production ? self::production_url : self::sandbox_url;

        $path = str_starts_with($path, '/') ? $path : '/'.$path;

        $path = $snap ? '/snap/v1' : "/{$version}{$path}";

        return $url.$path;
    }
}
