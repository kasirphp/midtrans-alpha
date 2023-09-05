<?php

namespace Kasir\Midtrans\Concerns;

trait CanMutateConfig
{
    private function addConfig(string $key, $value): void
    {
        $this->config = array_merge($this->config, [$key => $value]);
    }

    private function mergeConfig(array $config): void
    {
        $this->config = array_merge($this->config, $config);
    }
}