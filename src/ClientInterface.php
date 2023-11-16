<?php

namespace Kasir\Midtrans;

interface ClientInterface extends BaseClientInterface
{
    public function request($method, $path, $params, $opts);
}