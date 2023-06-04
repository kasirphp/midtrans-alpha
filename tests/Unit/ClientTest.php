<?php

use Kasir\Midtrans\Midtrans;

test('client can privately get auth key', function () {
    $key = 'some key';
    $client = Midtrans::client($key);
    $result = null;

    try {
        $reflectionMethod = new ReflectionMethod($client, 'getAuthKey');
        $result = $reflectionMethod->invoke($client);
    } catch (ReflectionException $e) {
        dump($e);
    }

    expect($result)
        ->toBeString()
        ->toBe($key);
});
