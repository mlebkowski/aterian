<?php

declare(strict_types=1);

namespace Aterian\Infrastructure;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use Throwable;

final class DevLogger implements LoggerInterface, \Aterian\Domain\Logger\Logger
{
    use LoggerTrait;

    public function log($level, Stringable|string $message, array $context = []): void
    {
        // noop;
    }

    public function logException(Throwable $e): void
    {
        $this->error($e->getMessage());
    }
}
