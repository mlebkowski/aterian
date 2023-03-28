<?php

namespace Aterian\Domain\Logger;

use Throwable;

interface Logger
{
    public function logException(Throwable $e): void;

    public function debug(string $message): void;
}
