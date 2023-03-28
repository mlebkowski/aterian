<?php

declare(strict_types=1);

namespace Aterian\Infrastructure;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class DevLogger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        // noop;
    }
}
