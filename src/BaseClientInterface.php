<?php

namespace Kasir\Midtrans;

interface BaseClientInterface
{
    public function getApiKey(): string;

    public function getApiBase(): string;
}