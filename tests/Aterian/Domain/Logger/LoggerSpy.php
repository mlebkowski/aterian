<?php

declare(strict_types=1);

namespace Aterian\Domain\Logger;

use Throwable;

final class LoggerSpy implements Logger
{
    /** @var string[] */
    public array $debug = [];
    /** @var Throwable[] */
    public array $exceptions = [];

    public function logException(Throwable $e): void
    {
        $this->exceptions[] = $e;
    }

    public function debug(string $message): void
    {
        $this->debug[] = $message;
    }
}
