<?php

namespace Kasir\Midtrans\Exceptions;

use Exception;
use Throwable;

/**
 * @internal
 */
final class KasirException extends Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
