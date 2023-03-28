<?php

declare(strict_types=1);

namespace Aterian\Infrastructure;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class Logger implements LoggerInterface
{
    use LoggerTrait;

    public static function instance(): self
    {
        return new self();
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        // noop
    }
}
