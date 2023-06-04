<?php

namespace Kasir\Midtrans\Responses;

use Kasir\Midtrans\Responses\Concerns\SuccessfulResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class Response
{
    use SuccessfulResponse;

    protected ResponseInterface $response;

    protected array|string|null $decoded = null;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->response = $response->withStatus(
            $this->json('status_code') ?? 500,
            $this->json('status_message') ?? 'There are no status message'
        );
    }

    public function body(): string
    {
        return (string) $this->response->getBody();
    }

    public function json($key = null, $default = null): array|string|null
    {
        if (! $this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return $this->decoded[$key] ?? $default;
    }

    public function status(): int
    {
        return (int) $this->response->getStatusCode();
    }

    public function reason(): string
    {
        return $this->response->getReasonPhrase();
    }

    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    public function redirect(): bool
    {
        return $this->status() >= 300 && $this->status() < 400;
    }

    public function failed(): bool
    {
        return $this->serverError() || $this->clientError();
    }

    public function clientError(): bool
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    public function serverError(): bool
    {
        return $this->status() >= 500;
    }

    public function onError(callable $callback): Response
    {
        if ($this->failed()) {
            $callback($this);
        }

        return $this;
    }

    public function close(): Response
    {
        $this->response->getBody()->close();

        return $this;
    }

    public function toPsrResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function toException(): \Exception
    {
        return new \Exception($this);
    }

    public function __toString(): string
    {
        return $this->body();
    }
}
