<?php

namespace Kasir\Midtrans;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Kasir\Midtrans\Responses\Response;
use Kasir\Midtrans\ValueObjects\BaseUrl;
use Kasir\Midtrans\ValueObjects\Headers;

/**
 * @internal
 */
final class Transporter
{
    public static function request(
        string $url,
        string $method,
        Headers $headers,
        array $params = [],
        string $version = null,
        bool $production = false
    ): Response {
        $url = BaseUrl::with(
            $url,
            production: $production,
            version: $version ?? 'v2'
        );

        $options = [
            'headers' => $headers->toArray(),
        ];

        $client = new GuzzleClient($options);

        try {
            $response = $client->$method($url, $params);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        return new Response($response);
    }
}
