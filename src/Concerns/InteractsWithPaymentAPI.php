<?php

namespace Kasir\Midtrans\Concerns;

use Kasir\Midtrans\Responses\Response;
use Kasir\Midtrans\Transaction;
use Kasir\Midtrans\Transporter;

/**
 * @internal
 */
trait InteractsWithPaymentAPI
{
    public function cardToken(int|string $card_number, int|string $exp_month, int|string $exp_year, int|string $cvv): Response
    {
        return Transporter::request(
            '/token',
            'get',
            $this->headers,
            null,
            [
                'query' => [
                    'client_key' => $this->getAuthKey(),
                    'card_number' => (string) $card_number,
                    'card_exp_month' => (string) $exp_month,
                    'card_exp_year' => (string) $exp_year,
                    'card_cvv' => (string) $cvv,
                ],
            ]
        );
    }

    public function charge(Transaction $transaction): Response
    {
        return Transporter::request(
            '/charge',
            'post',
            $this->headers,
            $transaction
        );
    }

    public function capture(Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Response => $id->transactionId(),
            default => $id,
        };

        return Transporter::request(
            '/capture',
            'post',
            $this->headers,
            null,
            [
                'json' => [
                    'transaction_id' => $id,
                ],
            ]
        );
    }

    public function cancel(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/cancel",
            'post',
            $this->headers
        );
    }

    public function expire(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/expire",
            'post',
            $this->headers
        );
    }

    public function refund(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/refund",
            'post',
            $this->headers
        );
    }

    public function directRefund(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/refund/online/direct",
            'post',
            $this->headers
        );
    }

    /**
     * @deprecated Waiting for Midtrans status update.
     */
    public function approve(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/approve",
            'post',
            $this->headers
        );
    }

    /**
     * @deprecated Waiting for Midtrans status update.
     */
    public function deny(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/deny",
            'post',
            $this->headers
        );
    }

    public function status(Transaction|Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/status",
            'get',
            $this->headers
        );
    }

    public function statusB2b(Transaction|Response|string $id, int $page = 0, int $per_page = 10): Response
    {
        $id = match (true) {
            $id instanceof Transaction => $id->getOrderId(),
            $id instanceof Response => $id->orderId(),
            default => $id,
        };

        return Transporter::request(
            "/{$id}/status/b2b",
            'get',
            $this->headers,
            null,
            [
                'query' => [
                    'page' => $page,
                    'per_page' => $per_page,
                ],
            ]
        );
    }

    public function cardRegister(int|string $card_number, int|string $exp_month, int|string $exp_year, string $callback = null): Response
    {
        return Transporter::request(
            '/card/register',
            'get',
            $this->headers,
            null,
            [
                'query' => [
                    'card_number' => (string) $card_number,
                    'card_exp_month' => (string) $exp_month,
                    'card_exp_year' => (string) $exp_year,
                    'client_key' => $this->getAuthKey(),
                    'callback' => $callback,
                ],
            ]
        );
    }

    public function bindGopay(int|string $phone_number, string|int $country_code, string $redirect_url = null): Response
    {
        $body = [
            'payment_type' => 'gopay',
            'gopay_partner' => [
                'phone_number' => $phone_number,
                'country_code' => $country_code,
            ],
        ];

        if ($redirect_url) {
            $body['gopay_partner']['redirect_url'] = $redirect_url;
        }

        return Transporter::request(
            '/pay/account',
            'post',
            $this->headers,
            null,
            [
                'json' => $body,
            ]
        );
    }

    public function unbindGopay(Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Response => $id->json('account_id'),
            default => $id,
        };

        return Transporter::request(
            "/pay/account/{$id}/unbind",
            'post',
            $this->headers
        );
    }

    public function statusGopay(Response|string $id): Response
    {
        $id = match (true) {
            $id instanceof Response => $id->json('account_id'),
            default => $id,
        };

        return Transporter::request(
            "/pay/account/{$id}",
            'get',
            $this->headers
        );
    }
}
