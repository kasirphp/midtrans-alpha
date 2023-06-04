<?php

test('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

test('API traits are only to be used in Client class')
    ->expect([
        \Kasir\Midtrans\Concerns\InteractsWithPaymentAPI::class,
        \Kasir\Midtrans\Concerns\InteractsWithSubscriptionAPI::class,
    ])
    ->toBeTraits()
    ->toOnlyBeUsedIn(\Kasir\Midtrans\Client::class);
